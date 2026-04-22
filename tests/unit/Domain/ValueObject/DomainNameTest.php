<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Domain\ValueObject;

use ArgumentCountError;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Domain\ValueObject\Label\LDHLabel;
use hiqdev\rdap\core\Domain\ValueObject\Label\NonASCIILabel;
use hiqdev\rdap\core\Domain\ValueObject\Label\RootLabel;
use PHPUnit\Framework\TestCase;

class DomainNameTest extends TestCase
{
    public function testSimpleDomain(): void
    {
        $domain = DomainName::of('example.com');
        $this->assertSame('example.com', (string) $domain);
        $this->assertSame(2, $domain->getLevelSize());
        $this->assertFalse($domain->isFQDN());
    }

    public function testFQDN(): void
    {
        $domain = DomainName::of('example.com.');
        $this->assertTrue($domain->isFQDN());
        $this->assertSame(2, $domain->getLevelSize());
        $this->assertSame('example.com.', (string) $domain);
    }

    public function testToFQDN(): void
    {
        $domain = DomainName::of('example.com');
        $fqdn = $domain->toFQDN();
        $this->assertTrue($fqdn->isFQDN());
        $this->assertSame('example.com.', (string) $fqdn);
    }

    public function testToFQDNIdempotent(): void
    {
        $domain = DomainName::of('example.com.');
        $fqdn = $domain->toFQDN();
        $this->assertSame($domain, $fqdn);
    }

    public function testGetLabels(): void
    {
        $domain = DomainName::of('sub.example.com');
        $labels = $domain->getLabels();
        $this->assertCount(3, $labels);
        $this->assertSame('sub', (string) $labels[0]);
        $this->assertSame('example', (string) $labels[1]);
        $this->assertSame('com', (string) $labels[2]);
    }

    public function testGetTLDLabel(): void
    {
        $domain = DomainName::of('example.com');
        $this->assertSame('com', (string) $domain->getTLDLabel());
    }

    public function testCaseNormalization(): void
    {
        $domain = DomainName::of('EXAMPLE.COM');
        $this->assertSame('example.com', (string) $domain);
    }

    public function testUnicodeDomain(): void
    {
        $domain = DomainName::of('тест.укр');
        $this->assertInstanceOf(NonASCIILabel::class, $domain->getLabels()[0]);
        $ldh = $domain->toLDH();
        $this->assertSame('xn--e1aybc.xn--j1amh', (string) $ldh);
    }

    public function testToUnicode(): void
    {
        $domain = DomainName::of('xn--e1aybc.xn--j1amh');
        $unicode = $domain->toUnicode();
        $this->assertSame('тест.укр', (string) $unicode);
    }

    public function testEquals(): void
    {
        $domain1 = DomainName::of('example.com');
        $domain2 = DomainName::of('EXAMPLE.COM');
        $domain3 = DomainName::of('other.com');
        $this->assertTrue($domain1->equals($domain2));
        $this->assertFalse($domain1->equals($domain3));
    }

    public function testEqualsSameInstance(): void
    {
        $domain = DomainName::of('example.com');
        $this->assertTrue($domain->equals($domain));
    }
}
