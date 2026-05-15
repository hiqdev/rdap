<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Infrastructure\DTO;

use hiqdev\rdap\core\Infrastructure\DTO\DomainData;
use PHPUnit\Framework\TestCase;

class DomainDataTest extends TestCase
{
    private function make(array $override = []): DomainData
    {
        $defaults = [
            'handle'              => 'D12345-CCTLD',
            'statuses'            => 'clientDeleteProhibited,clientTransferProhibited',
            'nameservers'         => 'ns1.example.com,ns2.example.com',
            'creationDate'        => '2010-01-01 00:00:00',
            'updatedDate'         => '2023-06-15 12:00:00',
            'registrarExpiration' => '2025-01-01 00:00:00',
            'expiration'          => '2025-01-01 00:00:00',
            'whoisProtected'      => false,
            'delegationSigned'    => false,
        ];
        $p = array_merge($defaults, $override);

        return new DomainData(
            $p['handle'],
            $p['statuses'],
            $p['nameservers'],
            $p['creationDate'],
            $p['updatedDate'],
            $p['registrarExpiration'],
            $p['expiration'],
            $p['whoisProtected'],
            $p['delegationSigned']
        );
    }

    public function testGetHandle(): void
    {
        $this->assertSame('D12345-CCTLD', $this->make()->getHandle());
    }

    public function testGetStatuses(): void
    {
        $dd = $this->make(['statuses' => 'ok,locked']);
        $this->assertSame('ok,locked', $dd->getStatuses());
    }

    public function testGetStatusesNull(): void
    {
        $dd = $this->make(['statuses' => null]);
        $this->assertNull($dd->getStatuses());
    }

    public function testGetNameservers(): void
    {
        $dd = $this->make(['nameservers' => 'ns1.example.com,ns2.example.com']);
        $this->assertSame('ns1.example.com,ns2.example.com', $dd->getNameservers());
    }

    public function testGetNameserversNull(): void
    {
        $dd = $this->make(['nameservers' => null]);
        $this->assertNull($dd->getNameservers());
    }

    public function testDatesAreParsedToUtc(): void
    {
        $dd = $this->make([
            'creationDate'        => '2010-03-15 10:00:00',
            'updatedDate'         => '2023-07-01 08:30:00',
            'registrarExpiration' => '2025-03-15 00:00:00',
            'expiration'          => '2025-03-15 00:00:00',
        ]);

        $this->assertSame('2010-03-15', $dd->getCreationDate()->format('Y-m-d'));
        $this->assertSame('2023-07-01', $dd->getUpdatedDate()->format('Y-m-d'));
        $this->assertSame('UTC', $dd->getCreationDate()->getTimezone()->getName());
        $this->assertSame('2025-03-15', $dd->getRegistrarExpiration()->format('Y-m-d'));
        $this->assertSame('2025-03-15', $dd->getExpiration()->format('Y-m-d'));
    }

    public function testIsWhoisProtected(): void
    {
        $this->assertFalse($this->make(['whoisProtected' => false])->isWhoisProtected());
        $this->assertTrue($this->make(['whoisProtected' => true])->isWhoisProtected());
    }

    public function testIsDelegationSigned(): void
    {
        $this->assertFalse($this->make(['delegationSigned' => false])->isDelegationSigned());
        $this->assertTrue($this->make(['delegationSigned' => true])->isDelegationSigned());
    }
}
