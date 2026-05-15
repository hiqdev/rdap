<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Domain\ValueObject;

use DateTimeImmutable;
use hiqdev\rdap\core\Domain\Constant\EventAction;
use hiqdev\rdap\core\Domain\ValueObject\Event;
use hiqdev\rdap\core\Domain\ValueObject\Link;
use hiqdev\rdap\core\Domain\ValueObject\SecureDNS;
use hiqdev\rdap\core\Domain\ValueObject\SecureDNS\DSData;
use hiqdev\rdap\core\Domain\ValueObject\SecureDNS\KeyData;
use PHPUnit\Framework\TestCase;

class SecureDNSTest extends TestCase
{
    public function testDefaultsUnsigned(): void
    {
        $sdns = new SecureDNS();
        $this->assertFalse($sdns->isDelegationSigned());
        $this->assertNull($sdns->isZoneSigned());
        $this->assertNull($sdns->getMaxSigLife());
        $this->assertNull($sdns->getDsData());
        $this->assertNull($sdns->getKeyData());
    }

    public function testDelegationSigned(): void
    {
        $sdns = new SecureDNS(null, true);
        $this->assertTrue($sdns->isDelegationSigned());
    }

    public function testZoneSigned(): void
    {
        $sdns = new SecureDNS(true);
        $this->assertTrue($sdns->isZoneSigned());
    }

    public function testMaxSigLife(): void
    {
        $sdns = new SecureDNS(null, false, 3600);
        $this->assertSame(3600, $sdns->getMaxSigLife());
    }

    public function testDsData(): void
    {
        $event   = Event::occurred(EventAction::LAST_CHANGED, new DateTimeImmutable());
        $link    = new Link('https://example.com');
        $dsData  = new DSData([$event], [$link], 8, 12345, 'aabbccdd', 2);
        $sdns    = new SecureDNS(true, true, null, [$dsData]);

        $this->assertCount(1, $sdns->getDsData());
        $this->assertSame($dsData, $sdns->getDsData()[0]);
    }

    public function testKeyData(): void
    {
        $event   = Event::occurred(EventAction::REGISTRATION, new DateTimeImmutable());
        $link    = new Link('https://example.com');
        $keyData = new KeyData([$event], [$link], 8, '256', '3', 'base64publickey==');
        $sdns    = new SecureDNS(null, false, null, null, [$keyData]);

        $this->assertCount(1, $sdns->getKeyData());
        $this->assertSame($keyData, $sdns->getKeyData()[0]);
    }

    // --- DSData ---

    public function testDsDataGetters(): void
    {
        $event = Event::occurred(EventAction::EXPIRATION, new DateTimeImmutable());
        $link  = new Link('https://iana.org');
        $ds    = new DSData([$event], [$link], 13, 54321, 'deadbeef', 1);

        $this->assertSame(13, $ds->getAlgorythm());
        $this->assertSame(54321, $ds->getKeyTag());
        $this->assertSame('deadbeef', $ds->getDigest());
        $this->assertSame(1, $ds->getDigestType());
        $this->assertSame([$event], $ds->getEvents());
        $this->assertSame([$link], $ds->getLinks());
    }

    public function testDsDataEmptyEventsAndLinks(): void
    {
        $ds = new DSData([], [], 5, 0, 'aa', 2);
        $this->assertSame([], $ds->getEvents());
        $this->assertSame([], $ds->getLinks());
    }

    // --- KeyData ---

    public function testKeyDataGetters(): void
    {
        $event = Event::occurred(EventAction::TRANSFER, new DateTimeImmutable());
        $link  = new Link('https://iana.org');
        $kd    = new KeyData([$event], [$link], 8, '257', '3', 'AQAB==');

        $this->assertSame(8, $kd->getAlgorythm());
        $this->assertSame('257', $kd->getFlags());
        $this->assertSame('3', $kd->getProtocol());
        $this->assertSame('AQAB==', $kd->getPublicKey());
        $this->assertSame([$event], $kd->getEvents());
        $this->assertSame([$link], $kd->getLinks());
    }

    public function testKeyDataEmptyEventsAndLinks(): void
    {
        $kd = new KeyData([], [], 13, '256', '3', 'key==');
        $this->assertSame([], $kd->getEvents());
        $this->assertSame([], $kd->getLinks());
    }
}
