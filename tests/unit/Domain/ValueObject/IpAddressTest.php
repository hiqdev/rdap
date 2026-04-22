<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Domain\ValueObject;

use hiqdev\rdap\core\Domain\ValueObject\IpV4Address;
use hiqdev\rdap\core\Domain\ValueObject\IpV6Address;
use hiqdev\rdap\core\Domain\ValueObject\IpAddresses;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class IpAddressTest extends TestCase
{
    public function testValidIpV4(): void
    {
        $ip = new IpV4Address('192.168.1.1');
        $this->assertSame('192.168.1.1', $ip->getHostAddress());
        $this->assertSame('192.168.1.1', (string) $ip);
    }

    public function testInvalidIpV4(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new IpV4Address('999.999.999.999');
    }

    public function testIpV6AsIpV4Rejected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new IpV4Address('::1');
    }

    public function testValidIpV6(): void
    {
        $ip = new IpV6Address('::1');
        $this->assertSame('::1', $ip->getHostAddress());
        $this->assertSame('::1', (string) $ip);
    }

    public function testFullIpV6(): void
    {
        $ip = new IpV6Address('2001:0db8:85a3:0000:0000:8a2e:0370:7334');
        $this->assertSame('2001:0db8:85a3:0000:0000:8a2e:0370:7334', $ip->getHostAddress());
    }

    public function testInvalidIpV6(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new IpV6Address('not-an-ipv6');
    }

    public function testIpV4AsIpV6Rejected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new IpV6Address('192.168.1.1');
    }

    public function testIpAddressesByProtocol(): void
    {
        $v4 = [new IpV4Address('8.8.8.8'), new IpV4Address('1.1.1.1')];
        $v6 = [new IpV6Address('::1')];
        $addresses = IpAddresses::getInstanceByProtocol($v4, $v6);
        $this->assertCount(2, $addresses->getV4());
        $this->assertCount(1, $addresses->getV6());
        $this->assertSame('8.8.8.8', (string) $addresses->getV4()[0]);
    }

    public function testIpAddressesByInetAddr(): void
    {
        $mixed = [
            new IpV4Address('8.8.8.8'),
            new IpV6Address('beef:babe::1'),
            new IpV4Address('1.1.1.1'),
        ];
        $addresses = IpAddresses::getInstanceByInetAddr($mixed);
        $this->assertCount(2, $addresses->getV4());
        $this->assertCount(1, $addresses->getV6());
    }

    public function testIpAddressesEmpty(): void
    {
        $addresses = IpAddresses::getInstanceByProtocol([], []);
        $this->assertCount(0, $addresses->getV4());
        $this->assertCount(0, $addresses->getV6());
    }
}
