<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Infrastructure\DTO;

use hiqdev\rdap\core\Infrastructure\DTO\DnsSecData;
use PHPUnit\Framework\TestCase;

class DnsSecDataTest extends TestCase
{
    public function testGetters(): void
    {
        $ds = new DnsSecData(12345, 8, 2, 'aabbccddeeff00112233');

        $this->assertSame(12345,                  $ds->getKeyTag());
        $this->assertSame(8,                      $ds->getAlgorithm());
        $this->assertSame(2,                      $ds->getDigestType());
        $this->assertSame('aabbccddeeff00112233', $ds->getDigest());
    }

    public function testSha1DigestType(): void
    {
        $ds = new DnsSecData(1, 5, 1, 'deadbeef');
        $this->assertSame(1, $ds->getDigestType());
    }

    public function testSha384DigestType(): void
    {
        $ds = new DnsSecData(999, 13, 4, 'longdigest');
        $this->assertSame(4, $ds->getDigestType());
        $this->assertSame(13, $ds->getAlgorithm());
    }

    public function testZeroKeyTag(): void
    {
        $ds = new DnsSecData(0, 8, 2, 'aa');
        $this->assertSame(0, $ds->getKeyTag());
    }
}
