<?php


namespace hiqdev\rdap\core\tests\unit\Domain\ValueObject;


use hiqdev\rdap\core\ValueObject\Event;
use hiqdev\rdap\core\ValueObject\Link;
use hiqdev\rdap\core\ValueObject\SecureDNS;
use PHPUnit\Framework\TestCase;

class SecureDNSTest extends TestCase
{

    /**
     * @depends DNSDataProvider
     * @param SecureDNS $secureDNS
     */
    public function testMain(SecureDNS $secureDNS): void
    {
        $secureDNS->getDsData();
    }

    protected function DNSDataProvider(): SecureDNS
    {
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
        return new SecureDNS(true, true, 10, $dsData, $keyData);
    }
}
