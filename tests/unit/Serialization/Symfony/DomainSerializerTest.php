<?php

declare(strict_types=1);
/**
 * Registration Data Access Protocol – core objects implemantation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\tests\unit\Serialization\Symfony;

use hiqdev\rdap\core\Entity\Domain;
use hiqdev\rdap\core\Entity\Nameserver;
use hiqdev\rdap\core\Serialization\Symfony\SymfonySerializer;
use hiqdev\rdap\core\ValueObject\DomainName;
use hiqdev\rdap\core\ValueObject\IpAddresses;
use PHPUnit\Framework\TestCase;

class DomainSerializerTest extends TestCase
{
    private function getSerializer(): SymfonySerializer
    {
        return new SymfonySerializer();
    }

    public function testSerialization()
    {
        $domain = new Domain(DomainName::of('тест.укр'));
        $domain->setHandle('AS-TEST');
        $domain->addNameserver(new Nameserver(
            DomainName::of('ns1.example.com'),
            IpAddresses::getInstanceByInetAddr(['8.8.8.8', '1.1.1.1', 'beef:babe::1'])
        ));
        $domain->addNameserver(new Nameserver(
            DomainName::of('ns2.example.com'),
            IpAddresses::getInstanceByInetAddr(['8.8.8.8', '1.1.1.1', 'beef:babe::1'])
        ));

        $json = $this->getSerializer()->serialize($domain);
        $result = json_decode($json, true);

        $stubFilename = __DIR__ . '/stub/full_domain_info.json';
        file_put_contents($stubFilename, $json);
        $this->assertJsonStringEqualsJsonFile($stubFilename, $json);
    }
}
