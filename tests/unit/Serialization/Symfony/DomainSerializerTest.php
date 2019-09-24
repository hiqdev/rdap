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
use hiqdev\rdap\core\Domain\Constant\EventAction;
use hiqdev\rdap\core\Domain\Constant\Relation;
use hiqdev\rdap\core\Domain\Constant\Role;
use hiqdev\rdap\core\Domain\Constant\Status;
use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\Entity\Entity;
use hiqdev\rdap\core\Domain\Entity\IPNetwork;
use hiqdev\rdap\core\Domain\Entity\Nameserver;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Domain\ValueObject\DomainVariant\Variant;
use hiqdev\rdap\core\Domain\ValueObject\Event;
use hiqdev\rdap\core\Domain\ValueObject\IpAddresses;
use hiqdev\rdap\core\Domain\ValueObject\Link;
use hiqdev\rdap\core\Domain\ValueObject\Notice;
use hiqdev\rdap\core\Domain\ValueObject\PublicId;
use hiqdev\rdap\core\Domain\ValueObject\SecureDNS;
use hiqdev\rdap\core\Infrastructure\Serialization\Symfony\SymfonySerializer;
use JeroenDesloovere\VCard\VCard;
use JeroenDesloovere\VCard\VCardDateMock;
use PHPUnit\Framework\TestCase;

class DomainSerializerTest extends TestCase
{
    protected function setUp(): void
    {
        VCardDateMock::setDate(new DateTimeImmutable('2011-01-10 10:20:30'));
    }

    private function getSerializer(): SymfonySerializer
    {
        return new SymfonySerializer();
    }

    public function testSerialization(): void
    {
        $domain = new Domain(DomainName::of('тест.укр'));
        $this->fillDomainWithTestData($domain);
        $json = $this->getSerializer()->serialize($domain);
        $stubFilename = __DIR__ . '/stub/full_domain_info.json';
//        file_put_contents($stubFilename, $json);
        $this->assertJsonStringEqualsJsonFile($stubFilename, $json);
    }

    public function testDeserialization(): void
    {
        $this->markTestIncomplete('Deserialization is not implemented yet.');
        // TODO: implement

        $domain = new Domain(DomainName::of('тест.укр'));
        $this->fillDomainWithTestData($domain);
        $serializer = $this->getSerializer();
        $json = $serializer->serialize($domain);
        $deserialized = $serializer->deserialize($json, Domain::class);
        $this->assertSame($domain, $deserialized);
    }

    private function fillDomainWithTestData(Domain $domain): void
    {
        $this->setHandle($domain);
        $this->addNameservers($domain);
        $this->addVariants($domain);
        $this->addEntities($domain);
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
        $ipNetwork->addStatus(Status::OK());
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
        $domain->addStatus(Status::OK());
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
        $link1 = new Link('kek.ua');
        $link1->setType('application/json');
        $link1->setTitle('title');
        $link2 = new Link('google.com');
        $link2->setType('plain/text');
        $link2->setTitle('new tittle');
        $domain->addLink($link1);
        $domain->addLink($link2);
    }

    private function addRemarks(Domain $domain): void
    {
        $domain->addRemark(new Notice('tittle1', 'type1', ['description1']));
        $domain->addRemark(new Notice('tittle2', 'type2', ['description2']));
        $domain->addRemark(new Notice('tittle3', 'type3', ['description3']));
    }

    private function addEntities(Domain $domain): void
    {
        $entity1 = new Entity();
        $entity1->addStatus(Status::OK());
        $entity1->setHandle('handle');
        $entity1->addPublicId(new PublicId('type', 'identifier'));
        $entity1->addRole(Role::RESELLER());
        $entity1->addAsEventActor(Event::occurred(EventAction::UNLOCKED(), new DateTimeImmutable('2019-07-03 11:12:15')));

        $entity2 = clone $entity1;
        $entity1->addEntity($entity2);

        $vcard = new VCard();
        $vcard->addEmail('text@example.com');
        $vcard->addPhoneNumber('+380931234567');
        $vcard->addName('Doe', 'John');
        $vcard->addCompany('Acme Inc');
//        $vcard->add

        $entity1->addVcard($vcard);
        $domain->addEntity($entity1);
    }
}
