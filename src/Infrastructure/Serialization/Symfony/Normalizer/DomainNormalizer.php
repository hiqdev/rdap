<?php

declare(strict_types=1);
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Infrastructure\Serialization\Symfony\Normalizer;

use DateTimeImmutable;
use hiqdev\rdap\core\Domain\Constant\EventAction;
use hiqdev\rdap\core\Domain\Constant\Relation;
use hiqdev\rdap\core\Domain\Constant\Role;
use hiqdev\rdap\core\Domain\Constant\Status;
use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\Entity\Entity;
use hiqdev\rdap\core\Domain\Entity\IPNetwork;
use hiqdev\rdap\core\Domain\Entity\Nameserver;
use hiqdev\rdap\core\Domain\Entity\VCard;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Domain\ValueObject\DomainVariant\Variant;
use hiqdev\rdap\core\Domain\ValueObject\Event;
use hiqdev\rdap\core\Domain\ValueObject\IpAddresses;
use hiqdev\rdap\core\Domain\ValueObject\IpV4Address;
use hiqdev\rdap\core\Domain\ValueObject\IpV6Address;
use hiqdev\rdap\core\Domain\ValueObject\Link;
use hiqdev\rdap\core\Domain\ValueObject\Notice;
use hiqdev\rdap\core\Domain\ValueObject\PublicId;
use hiqdev\rdap\core\Domain\ValueObject\SecureDNS;
use hiqdev\rdap\core\Domain\ValueObject\SecureDNS\DSData;
use hiqdev\rdap\core\Domain\ValueObject\SecureDNS\KeyData;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Denormalizes a decoded RDAP JSON array into a fully-constructed {@see Domain} object.
 *
 * Handles all nested types: Event, Link, Notice, Nameserver, Variant, Entity,
 * VCard (jCard), SecureDNS (DSData / KeyData), and IPNetwork.
 */
final class DomainNormalizer implements DenormalizerInterface, CacheableSupportsMethodInterface
{
    /** @return bool Always true — denormalisation support result is stable across calls */
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    /** @return bool True only when the target type is {@see Domain} */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $type === Domain::class;
    }

    /**
     * @param array  $data    Decoded RDAP JSON array
     * @param string $type    Must be {@see Domain}::class
     * @return Domain
     */
    public function denormalize($data, $type, $format = null, array $context = []): Domain
    {
        $domain = new Domain(DomainName::of($data['ldhName']));

        if (isset($data['rdapConformance'])) {
            $domain->setRdapConformance($data['rdapConformance']);
        }
        if (isset($data['handle'])) {
            $domain->setHandle($data['handle']);
        }
        if (isset($data['lang'])) {
            $domain->setLang($data['lang']);
        }
        if (isset($data['port43'])) {
            $domain->setPort43(DomainName::of($data['port43']));
        }
        foreach ($data['publicIds'] ?? [] as $pid) {
            $domain->addPublicId(new PublicId($pid['type'], $pid['identifier']));
        }
        foreach ($data['status'] ?? [] as $s) {
            $domain->addStatus(Status::from($s));
        }
        foreach ($data['events'] ?? [] as $e) {
            $domain->addEvent($this->buildEvent($e));
        }
        foreach ($data['links'] ?? [] as $l) {
            $domain->addLink($this->buildLink($l));
        }
        foreach ($data['notices'] ?? [] as $n) {
            $domain->addNotice($this->buildNotice($n));
        }
        foreach ($data['remarks'] ?? [] as $r) {
            $domain->addRemark($this->buildNotice($r));
        }
        foreach ($data['variants'] ?? [] as $v) {
            $domain->addVariant($this->buildVariant($v));
        }
        foreach ($data['nameservers'] ?? [] as $ns) {
            $domain->addNameserver($this->buildNameserver($ns));
        }
        if (!empty($data['secureDNS'])) {
            $domain->setSecureDNS($this->buildSecureDNS($data['secureDNS']));
        }
        foreach ($data['entities'] ?? [] as $e) {
            $domain->addEntity($this->buildEntity($e));
        }
        if (!empty($data['network'])) {
            $domain->setNetwork($this->buildIPNetwork($data['network']));
        }

        return $domain;
    }

    private function buildEvent(array $data): Event
    {
        $event = Event::occurred(
            EventAction::from($data['eventAction']),
            new DateTimeImmutable($data['eventDate'])
        );
        foreach ($data['links'] ?? [] as $l) {
            $event->addLink($this->buildLink($l));
        }
        if (!empty($data['eventActor'])) {
            $event->setEventActor($data['eventActor']);
        }
        return $event;
    }

    private function buildLink(array $data): Link
    {
        $link = new Link($data['href']);
        if (isset($data['value'])) {
            $link->setValue($data['value']);
        }
        if (isset($data['rel'])) {
            $link->setRel($data['rel']);
        }
        if (isset($data['type'])) {
            $link->setType($data['type']);
        }
        if (isset($data['title'])) {
            $link->setTitle($data['title']);
        }
        if (isset($data['media'])) {
            $link->setMedia($data['media']);
        }
        foreach ($data['hreflang'] ?? [] as $lang) {
            $link->addHrefLang($lang);
        }
        return $link;
    }

    private function buildNotice(array $data): Notice
    {
        $links = array_map([$this, 'buildLink'], $data['links'] ?? []);
        $notice = new Notice($data['title'], $data['description'] ?? [], $links);
        if (isset($data['type'])) {
            $notice->setType($data['type']);
        }
        return $notice;
    }

    private function buildVariant(array $data): Variant
    {
        $relations = array_map(fn(string $r) => Relation::from($r), $data['relations'] ?? []);
        return new Variant($relations, $data['idnTable'] ?? '', $data['variantNames'] ?? []);
    }

    private function buildNameserver(array $data): Nameserver
    {
        $ipAddresses = null;
        if (isset($data['ipAddresses'])) {
            $v4 = array_map(fn(string $ip) => new IpV4Address($ip), $data['ipAddresses']['v4'] ?? []);
            $v6 = array_map(fn(string $ip) => new IpV6Address($ip), $data['ipAddresses']['v6'] ?? []);
            $ipAddresses = IpAddresses::getInstanceByProtocol($v4, $v6);
        }
        $ns = new Nameserver(DomainName::of($data['ldhName']), $ipAddresses);
        if (isset($data['handle'])) {
            $ns->setHandle($data['handle']);
        }
        return $ns;
    }

    private function buildEntity(array $data): Entity
    {
        $entity = new Entity();
        if (isset($data['handle'])) {
            $entity->setHandle($data['handle']);
        }
        foreach ($data['roles'] ?? [] as $r) {
            $entity->addRole(Role::from($r));
        }
        foreach ($data['status'] ?? [] as $s) {
            $entity->addStatus(Status::from($s));
        }
        foreach ($data['asEventActor'] ?? [] as $e) {
            $entity->addAsEventActor($this->buildEvent($e));
        }
        foreach ($data['publicIds'] ?? [] as $pid) {
            $entity->addPublicId(new PublicId($pid['type'], $pid['identifier']));
        }
        foreach ($data['entities'] ?? [] as $sub) {
            $entity->addEntity($this->buildEntity($sub));
        }
        if (!empty($data['vcardArray'])) {
            $entity->addVcard($this->buildVCard($data['vcardArray']));
        }
        return $entity;
    }

    private function buildVCard(array $vcardArray): VCard
    {
        $vcard = new VCard();
        foreach ($vcardArray[1] ?? [] as [$name, $params, , $value]) {
            $params = is_array($params) ? $params : [];
            match ($name) {
                'version' => null,
                'fn'      => $vcard->setFullName($value, $params),
                'n'       => $vcard->setName($value, $params),
                'email'   => $vcard->setEmail($value, $params),
                'org'     => $vcard->setOrg($value, $params),
                'tel'     => $vcard->setTel($value, $params),
                'url'     => $vcard->setUrl($value, $params),
                'adr'     => $vcard->setAddress(
                    $value[2] ?? '',
                    $value[3] ?? '',
                    $value[5] ?? '',
                    $params['cc'] ?? null,
                    $value[4] ?? '',
                    $value[1] ?? '',
                    $value[0] ?? '',
                    $params
                ),
                default => null,
            };
        }
        return $vcard;
    }

    private function buildSecureDNS(array $data): SecureDNS
    {
        $dsData = array_map(function (array $d): DSData {
            $events = array_map([$this, 'buildEvent'], $d['events'] ?? []);
            $links  = array_map([$this, 'buildLink'],  $d['links']  ?? []);
            return new DSData($events, $links, (int) $d['algorythm'], (int) $d['keyTag'], (string) $d['digest'], (int) $d['digestType']);
        }, $data['dsData'] ?? []);

        $keyData = array_map(function (array $d): KeyData {
            $events = array_map([$this, 'buildEvent'], $d['events'] ?? []);
            $links  = array_map([$this, 'buildLink'],  $d['links']  ?? []);
            return new KeyData($events, $links, (int) $d['algorythm'], (string) $d['flags'], (string) $d['protocol'], (string) $d['publicKey']);
        }, $data['keyData'] ?? []);

        return new SecureDNS(
            $data['zoneSigned'] ?? null,
            $data['delegationSigned'] ?? false,
            isset($data['maxSigLife']) ? (int) $data['maxSigLife'] : null,
            $dsData ?: null,
            $keyData ?: null
        );
    }

    private function buildIPNetwork(array $data): IPNetwork
    {
        $network = new IPNetwork();
        foreach ($data['status'] ?? [] as $s) {
            $network->addStatus(Status::from($s));
        }
        if (isset($data['handle'])) {
            $network->setHandle($data['handle']);
        }
        return $network;
    }
}
