<?php declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Serialization\Symfony;

use hiqdev\rdap\core\Entity\Domain;
use hiqdev\rdap\core\Entity\Nameserver;
use hiqdev\rdap\core\Serialization\Symfony\SymfonySerializer;
use hiqdev\rdap\core\ValueObject\DomainName;
use hiqdev\rdap\core\ValueObject\IpAddresses;
use hiqdev\rdap\core\ValueObject\Link;
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
