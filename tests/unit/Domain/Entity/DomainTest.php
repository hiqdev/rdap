<?php
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\tests\unit\Domain\Entity;

use hiqdev\rdap\core\Domain\Constant\EventAction;
use hiqdev\rdap\core\Domain\Constant\Status;
use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\Entity\Entity;
use hiqdev\rdap\core\Domain\Entity\IPNetwork;
use hiqdev\rdap\core\Domain\Entity\Nameserver;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Domain\ValueObject\DomainVariant\Name;
use hiqdev\rdap\core\Domain\ValueObject\DomainVariant\Variant;
use hiqdev\rdap\core\Domain\ValueObject\Event;
use hiqdev\rdap\core\Domain\ValueObject\IpAddresses;
use hiqdev\rdap\core\Domain\ValueObject\Link;
use hiqdev\rdap\core\Domain\ValueObject\PublicId;
use hiqdev\rdap\core\Domain\ValueObject\SecureDNS;
use PHPUnit\Framework\TestCase;

class DomainTest extends TestCase
{
    public function testLdhName(): void
    {
        $domain = new Domain(DomainName::of('example.com'));
        $this->assertSame('example.com', (string) $domain->getLdhName());
    }

    public function testNameserver(): void
    {
        $domain = new Domain(DomainName::of('example.com'));
        $ns1 = new Nameserver(
            DomainName::of('ns1.example.com'),
            IpAddresses::getInstanceByInetAddr(['8.8.8.8', '1.1.1.1', 'beef:babe::1'])
        );
        $handle = 'handle';
        $ns1->setHandle($handle);
        $this->assertSame($handle, $ns1->getHandle());
        $ns2 = new Nameserver(
            DomainName::of('ns2.example.com'),
            IpAddresses::getInstanceByInetAddr(['8.8.8.8', '1.1.1.1', 'beef:babe::1'])
        );
        $domain->addNameserver($ns1);
        $domain->addNameserver($ns2);
        $this->assertSame([$ns1, $ns2], $domain->getNameservers());
    }

    public function testPublicId(): void
    {
        $domain = new Domain(DomainName::of('example.com'));
        $pubId1 = new PublicId('type', 'identifier');
        $pubId2 = new PublicId('type2', 'identifier2');
        $domain->addPublicId($pubId1);
        $domain->addPublicId($pubId2);
        $this->assertSame([$pubId1, $pubId2], $domain->getPublicIds());
    }

    public function testVariant(): void
    {
        $domain = new Domain(DomainName::of('example.com'));
        $name1 = new Name(DomainName::of('ns1.example.com'), DomainName::of('ns1.example.com'));
        $name2 = new Name(DomainName::of('ns2.example.com'), DomainName::of('ns2.example.com'));
        $variant1 = new Variant([], 'idnTable1', [$name1, $name2]);
        $variant2 = new Variant([], 'idnTable2', [$name1, $name2]);
        $domain->addVariant($variant1);
        $domain->addVariant($variant2);
        $this->assertSame([$variant1, $variant2], $domain->getVariants());
    }

    public function testSecureDNS(): void
    {
        $domain = new Domain(DomainName::of('example.com'));
        $eventArr = [
            Event::occurred(EventAction::LAST_CHANGED(), new \DateTimeImmutable()),
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
        $secureDns = new SecureDNS(true, true, 10, $dsData, $keyData);
        $domain->setSecureDNS($secureDns);
        $this->assertSame($secureDns, $domain->getSecureDNS());
    }

    public function testEntity(): void
    {
        $domain = new Domain(DomainName::of('example.com'));
        $entity1 = new Entity();
        $entity1->addStatus(Status::OK());
        $entity2 = new Entity();
        $entity2->addStatus(Status::LOCKED());
        $domain->addEntity($entity1);
        $domain->addEntity($entity2);
        $this->assertSame([$entity1, $entity2], $domain->getEntities());
    }

    public function testNetwork(): void
    {
        $domain = new Domain(DomainName::of('example.com'));
        $ipNetwork = new IPNetwork();
        $domain->setNetwork($ipNetwork);
        $this->assertSame($ipNetwork, $domain->getNetwork());
    }

    public function testHandle(): void
    {
        $domain = new Domain(DomainName::of('example.com'));
        $handle = 'handle';
        $domain->setHandle($handle);
        $this->assertSame($handle, $domain->getHandle());
    }

    public function testUnicodeDomain(): void
    {
        $domain = new Domain(DomainName::of('тест.укр'));

        $this->assertSame('xn--e1aybc.xn--j1amh', (string) $domain->getLdhName());
        $this->assertSame('тест.укр', (string) $domain->getLdhName()->toUnicode());
        $this->assertSame('xn--e1aybc.xn--j1amh', (string) $domain->getLdhName()->toLDH());

        $this->assertSame('тест.укр.', (string) $domain->getLdhName()->toUnicode()->toFQDN());
        $this->assertSame('xn--e1aybc.xn--j1amh.', (string) $domain->getLdhName()->toFQDN());
        $this->assertSame('xn--e1aybc.xn--j1amh.', (string) $domain->getLdhName()->toLDH()->toFQDN());
    }

    public function testMixedCaseDomain(): void
    {
        $domain = new Domain(DomainName::of('UPPERCASED.com'));
        $this->assertSame('uppercased.com', (string) $domain->getLdhName());

        $domain = new Domain(DomainName::of('ЗмішанаКапіталізація.укр'));
        $this->assertSame('змішанакапіталізація.укр', (string) $domain->getLdhName()->toUnicode());
        $this->assertSame('xn--80aaaaa1bevlem1a3byds8jrehdd.xn--j1amh', (string) $domain->getLdhName());
    }
}
