<?php

declare(strict_types=1);
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\tests\unit\Serialization\Symfony;

use DateTimeImmutable;
use hiqdev\rdap\core\Constant\EventAction;
use hiqdev\rdap\core\Constant\Relation;
use hiqdev\rdap\core\Constant\Status;
use hiqdev\rdap\core\Entity\Domain;
use hiqdev\rdap\core\Entity\IPNetwork;
use hiqdev\rdap\core\Entity\Nameserver;
use hiqdev\rdap\core\Serialization\Symfony\SymfonySerializer;
use hiqdev\rdap\core\ValueObject\DomainName;
use hiqdev\rdap\core\ValueObject\DomainVariant\Variant;
use hiqdev\rdap\core\ValueObject\Event;
use hiqdev\rdap\core\ValueObject\IpAddresses;
use hiqdev\rdap\core\ValueObject\Link;
use hiqdev\rdap\core\ValueObject\Notice;
use hiqdev\rdap\core\ValueObject\PublicId;
use hiqdev\rdap\core\ValueObject\SecureDNS;
use PHPUnit\Framework\TestCase;

class DomainSerializerTest extends TestCase
{
    private function getSerializer(): SymfonySerializer
    {
        return new SymfonySerializer();
    }

    public function testSerialization()
    {
        $domain = new Domain(DomainName::of('тест.укр'));
        $this->fillDomainWithTestData($domain);
        $json = $this->getSerializer()->serialize($domain);
        $stubFilename = __DIR__ . '/stub/full_domain_info.json';
//        file_put_contents($stubFilename, $json);
        $this->assertJsonStringEqualsJsonFile($stubFilename, $json);
    }

    private function fillDomainWithTestData(Domain $domain): void
    {
        $this->setHandle($domain);
        $this->addNameservers($domain);
        $this->addVariants($domain);
        $this->setSecureDNS($domain);
        $this->setNetwork($domain);
        $this->setLang($domain);
        $this->addPublicIds($domain);
        $this->addStatuses($domain);
        $this->addEvents($domain);
        $this->setPort43($domain);
        $this->addLinks($domain);
        $this->addRemarks($domain);
    }

    private function setHandle(Domain $domain): void
    {
        $domain->setHandle('AS-TEST');
    }

    private function addNameservers(Domain $domain): void
    {
        $domain->addNameserver(new Nameserver(DomainName::of('ns1.example.com'),
            IpAddresses::getInstanceByInetAddr(['8.8.8.8', '1.1.1.1', 'beef:babe::1'])));
        $domain->addNameserver(new Nameserver(DomainName::of('ns2.example.com'),
            IpAddresses::getInstanceByInetAddr(['8.8.8.8', '1.1.1.1', 'beef:babe::1'])));
    }

    private function addVariants(Domain $domain): void
    {
        $relations = [
            Relation::REGISTERED(),
            Relation::UNREGISTERED(),
        ];
        $domain->addVariant(new Variant($relations, 'idnTable1'));
        $domain->addVariant(new Variant($relations, 'idnTable2'));
    }

    private function setSecureDNS(Domain $domain): void
    {
        $eventArr = [
            Event::occurred(EventAction::DELETION(), new DateTimeImmutable('2019-08-01 11:12:13')),
        ];
        $linkArr = [
            new Link('scheme'),
        ];
        $dsData = [
            new SecureDNS\DSData($eventArr, $linkArr, 0, 0, 'digest', 0),
        ];
        $keyData = [
            new SecureDNS\KeyData($eventArr, $linkArr, 0, 'flags', 'protocol', 'pb_key'),
        ];
        $domain->setSecureDNS(new SecureDNS(true, true, 10, $dsData, $keyData));
    }

    private function setNetwork(Domain $domain): void
    {
        $ipNetwork = new IPNetwork();
        $ipNetwork->addStatus(Status::ACTIVE());
        $domain->setNetwork($ipNetwork);
    }

    private function setLang(Domain $domain): void
    {
        $domain->setLang('english');
    }

    private function addPublicIds(Domain $domain): void
    {
        $domain->addPublicId(new PublicId('type1', 'identifier1'));
        $domain->addPublicId(new PublicId('type2', 'identifier2'));
        $domain->addPublicId(new PublicId('type3', 'identifier3'));
    }

    private function addStatuses(Domain $domain): void
    {
        $domain->addStatus(Status::ACTIVE());
        $domain->addStatus(Status::LOCKED());
    }

    private function addEvents(Domain $domain): void
    {
        $domain->addEvent(Event::occurred(EventAction::DELETION(), new DateTimeImmutable('2019-08-01 00:00:01')));
        $domain->addEvent(Event::occurred(EventAction::DELETION(), new DateTimeImmutable('2019-08-01 00:00:01')));
        $domain->addEvent(Event::occurred(EventAction::DELETION(), new DateTimeImmutable('2019-08-01 00:00:01')));
    }

    private function setPort43(Domain $domain): void
    {
        $domain->setPort43(DomainName::of('ns1.example.com'));
    }

    private function addLinks(Domain $domain): void
    {
        $domain->addLink(new Link('scheme1'));
        $domain->addLink(new Link('scheme2', 'user'));
    }

    private function addRemarks(Domain $domain): void
    {
        $domain->addRemark(new Notice('tittle1', 'type1', 'description1'));
        $domain->addRemark(new Notice('tittle2', 'type2', 'description2'));
        $domain->addRemark(new Notice('tittle3', 'type3', 'description3'));
    }
}
