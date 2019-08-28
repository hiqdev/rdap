<?php

namespace hiqdev\rdap\core\tests\unit\Domain\Entity;

use hiqdev\rdap\core\Entity\Domain;
use hiqdev\rdap\core\Entity\Nameserver;
use hiqdev\rdap\core\ValueObject\DomainName;
use hiqdev\rdap\core\ValueObject\IpAddresses;
use PHPUnit\Framework\TestCase;

class DomainTest extends TestCase
{
    public function testProperties(): void
    {
        $domain = new Domain(DomainName::of('example.com'));

        $this->assertSame('example.com', (string)$domain->getLdhName());

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

        // TODO: continue
    }

    public function testUnitcodeDomain()
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
