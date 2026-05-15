<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Domain\Entity;

use hiqdev\rdap\core\Domain\Entity\Nameserver;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Domain\ValueObject\IpAddresses;
use hiqdev\rdap\core\Domain\ValueObject\IpV4Address;
use hiqdev\rdap\core\Domain\ValueObject\IpV6Address;
use PHPUnit\Framework\TestCase;

class NameserverTest extends TestCase
{
    public function testLdhNameIsStoredAsLdh(): void
    {
        $ns = new Nameserver(DomainName::of('ns1.example.com'));
        $this->assertSame('ns1.example.com', (string) $ns->getLdhName());
    }

    public function testUnicodeNameIsNormalisedToLdh(): void
    {
        $ns = new Nameserver(DomainName::of('ns1.тест.укр'));
        $this->assertSame('ns1.xn--e1aybc.xn--j1amh', (string) $ns->getLdhName());
    }

    public function testHandleNullByDefault(): void
    {
        $ns = new Nameserver(DomainName::of('ns1.example.com'));
        $this->assertNull($ns->getHandle());
    }

    public function testSetHandle(): void
    {
        $ns = new Nameserver(DomainName::of('ns1.example.com'));
        $ns->setHandle('NS-001');
        $this->assertSame('NS-001', $ns->getHandle());
    }

    public function testSetHandleToNull(): void
    {
        $ns = new Nameserver(DomainName::of('ns1.example.com'));
        $ns->setHandle('NS-001');
        $ns->setHandle(null);
        $this->assertNull($ns->getHandle());
    }

    public function testIpAddressesNullByDefault(): void
    {
        $ns = new Nameserver(DomainName::of('ns1.example.com'));
        $this->assertNull($ns->getIpAddresses());
    }

    public function testIpAddressesStoredWhenProvided(): void
    {
        $ips = IpAddresses::getInstanceByProtocol(
            [new IpV4Address('1.2.3.4')],
            [new IpV6Address('::1')]
        );
        $ns = new Nameserver(DomainName::of('ns1.example.com'), $ips);
        $this->assertSame($ips, $ns->getIpAddresses());
        $this->assertCount(1, $ns->getIpAddresses()->getV4());
        $this->assertCount(1, $ns->getIpAddresses()->getV6());
    }

    public function testObjectClassNameIsNameserver(): void
    {
        $ns = new Nameserver(DomainName::of('ns1.example.com'));
        $this->assertSame('nameserver', $ns->getObjectClassName()->value);
    }
}
