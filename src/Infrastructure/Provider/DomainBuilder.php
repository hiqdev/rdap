<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Provider;

use DateTimeImmutable;
use hiqdev\rdap\core\Domain\Constant\EventAction;
use hiqdev\rdap\core\Domain\Constant\Status;
use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\Entity\Nameserver;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Domain\ValueObject\Event;
use hiqdev\rdap\core\Domain\ValueObject\Link;
use hiqdev\rdap\core\Infrastructure\DTO\ContactDataInterface;
use hiqdev\rdap\core\Infrastructure\DTO\DnsSecDataInterface;
use hiqdev\rdap\core\Infrastructure\DTO\DomainDataInterface;

/**
 * Assembles a fully populated RDAP Domain entity from raw DTO data.
 *
 * Wires together contacts (via ContactBuilderInterface), the registrar entity
 * (via RegistrarBuilderInterface), DNSSEC data (via SecureDnsBuilderInterface),
 * ICANN notices (via NoticeBuilderInterface), EPP statuses, nameservers, events,
 * redacted fields, self link, and port43.
 */
final class DomainBuilder implements DomainBuilderInterface
{
    /**
     * @param string                    $whoisUrl        Hostname of the WHOIS server (port43)
     * @param array                     $rdapConformance rdapConformance strings to embed in every response
     * @param string                    $rdapUrl         Base URL of this RDAP service (prefix for self links)
     * @param ContactBuilderInterface   $contactBuilder  Builds vCard entities from contact DTOs
     * @param RegistrarBuilderInterface $registrarBuilder Builds the registrar entity
     * @param NoticeBuilderInterface    $noticeBuilder   Builds ICANN-required notice objects
     * @param SecureDnsBuilderInterface $secureDnsBuilder Builds the secureDNS object from DS records
     */
    public function __construct(
        private string $whoisUrl,
        private array $rdapConformance,
        private string $rdapUrl,
        private ContactBuilderInterface $contactBuilder,
        private RegistrarBuilderInterface $registrarBuilder,
        private NoticeBuilderInterface $noticeBuilder,
        private SecureDnsBuilderInterface $secureDnsBuilder,
    ) {
    }

    /**
     * @param ContactDataInterface[] $contacts
     * @param DnsSecDataInterface[]|null $secureDnsData
     */
    public function build(
        DomainName $domainName,
        DomainDataInterface $domainData,
        array $contacts,
        ?array $secureDnsData
    ): Domain {
        $domain = new Domain($domainName);
        $domain->setRdapConformance($this->rdapConformance);
        $domain->setHandle($domainData->getHandle());

        $domainUrl = $this->rdapUrl . (string)$domainName;
        $selfLink  = new Link($domainUrl);
        $selfLink->setValue($domainUrl);
        $selfLink->setType('application/rdap+json');
        $selfLink->setRel('self');
        $domain->addLink($selfLink);

        $domain->setSecureDNS($this->secureDnsBuilder->build(
            $secureDnsData ?? [],
            $domainData->isDelegationSigned(),
        ));

        foreach ($this->contactBuilder->build($contacts) as $entity) {
            $domain->addEntity($entity);
        }
        $domain->addEntity($this->registrarBuilder->build());

        $domain->addEvent(Event::occurred(EventAction::REGISTRATION,                 $domainData->getCreationDate()));
        if ($domainData->getUpdatedDate() != $domainData->getCreationDate()) {
            $domain->addEvent(Event::occurred(EventAction::LAST_CHANGED,             $domainData->getUpdatedDate()));
        }
        $domain->addEvent(Event::occurred(EventAction::REGISTRAR_EXPIRATION,         $domainData->getRegistrarExpiration()));
        $domain->addEvent(Event::occurred(EventAction::EXPIRATION,                   $domainData->getExpiration()));
        $domain->addEvent(Event::occurred(EventAction::LAST_UPDATE_OF_RDAP_DATABASE, new DateTimeImmutable()));

        $statuses = $domainData->getStatuses();
        if (!empty($statuses)) {
            foreach (explode(',', $statuses) as $status) {
                $domain->addStatus(Status::fromName(strtoupper($status)));
            }
        } else {
            $domain->addStatus(Status::OK);
        }

        $nameservers = $domainData->getNameservers();
        if (!empty($nameservers)) {
            foreach (explode(',', $nameservers) as $host) {
                $domain->addNameserver(new Nameserver(DomainName::of($host)));
            }
        }

        $domain->setPort43(DomainName::of($this->whoisUrl));
        $domain->setLang(getenv('RDAP_LANG') ?: 'en');
        $domain->setRedacted($domainData->isWhoisProtected());

        foreach ($this->noticeBuilder->build($domainUrl) as $notice) {
            $domain->addNotice($notice);
        }

        return $domain;
    }
}
