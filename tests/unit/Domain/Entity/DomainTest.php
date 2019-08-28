<?php

namespace hiqdev\rdap\core\tests\unit\Domain\Entity;

use hiqdev\rdap\core\Entity\Domain;
use hiqdev\rdap\core\Entity\Nameserver;
use hiqdev\rdap\core\ValueObject\Link;
use hiqdev\rdap\core\ValueObject\DomainName;
use hiqdev\rdap\core\ValueObject\DomainVariant\Name;
use hiqdev\rdap\core\ValueObject\DomainVariant\Variant;
use hiqdev\rdap\core\ValueObject\Event;
use hiqdev\rdap\core\ValueObject\IpAddresses;
use hiqdev\rdap\core\ValueObject\PublicId;
use hiqdev\rdap\core\ValueObject\SecureDNS;
use PHPUnit\Framework\TestCase;

class DomainTest extends TestCase
{
    public function testLdhName(): void
    {
        $domain = new Domain(DomainName::of('example.com'));
        $this->assertSame('example.com', (string)$domain->getLdhName());
    }

    public function testNameserver(): void
    {
        $domain = new Domain(DomainName::of('example.com'));
        $ns1 = new Nameserver(
            DomainName::of('ns1.example.com'),
            IpAddresses::getInstanceByInetAddr(['8.8.8.8', '1.1.1.1', 'beef:babe::1'])
        );
        $ns2 = new Nameserver(
            DomainName::of('ns2.example.com'),
            IpAddresses::getInstanceByInetAddr(['8.8.8.8', '1.1.1.1', 'beef:babe::1'])
        );
        $domain->addNameserver($ns1);
        $domain->addNameserver($ns2);
        $this->assertSame([$ns1, $ns2], $domain->getNameservers());
    }

    public function testPublicId()
    {
        $domain = new Domain(DomainName::of('example.com'));
        $pubId1 = new PublicId('type', 'identifier');
        $pubId2 = new PublicId('type2', 'identifier2');
        $domain->addPublicId($pubId1);
        $domain->addPublicId($pubId2);
        $this->assertSame([$pubId1, $pubId2], $domain->getPublicIds());
    }

    public function testVariant()
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

    public function testSecureDNS()
    {
        $domain = new Domain(DomainName::of('example.com'));
        $eventArr = [
            Event::occurred('action', new \DateTimeImmutable())
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

    public function testUnicodeDomain()
    {
        $domain = new Domain(DomainName::of('тест.укр'));

        $this->assertSame('xn--e1aybc.xn--j1amh', (string)$domain->getLdhName());
        $this->assertSame('тест.укр', (string)$domain->getLdhName()->toUnicode());
        $this->assertSame('xn--e1aybc.xn--j1amh', (string)$domain->getLdhName()->toLDH());

        $this->assertSame('тест.укр.', (string)$domain->getLdhName()->toUnicode()->toFQDN());
        $this->assertSame('xn--e1aybc.xn--j1amh.', (string)$domain->getLdhName()->toFQDN());
        $this->assertSame('xn--e1aybc.xn--j1amh.', (string)$domain->getLdhName()->toLDH()->toFQDN());
    }
}
