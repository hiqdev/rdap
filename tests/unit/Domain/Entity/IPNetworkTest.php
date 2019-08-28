<?php


namespace hiqdev\rdap\core\tests\unit\Domain\Entity;


use hiqdev\rdap\core\Constant\Status;
use hiqdev\rdap\core\Entity\Entity;
use hiqdev\rdap\core\Entity\IPNetwork;
use hiqdev\rdap\core\ValueObject\InetAddress;
use PHPUnit\Framework\TestCase;

class IPNetworkTest extends TestCase
{
    public function testInetAddress(): void
    {
        $ipNetwork = new IPNetwork();
        $inetAddress = new InetAddress();
        $ipNetwork->setStartAddress($inetAddress);
        $this->assertSame($inetAddress, $ipNetwork->getStartAddress());
        $ipNetwork->setEndAddress($inetAddress);
        $this->assertSame($inetAddress, $ipNetwork->getEndAddress());
    }

    public function testEntity(): void
    {
        $ipNetwork = new IPNetwork();
        $entity1 = new Entity();
        $entity1->addStatus(Status::ACTIVE());
        $entity2 = new Entity();
        $entity2->addStatus(Status::LOCKED());
        $ipNetwork->addEntity($entity1);
        $ipNetwork->addEntity($entity2);
        $this->assertSame([$entity1, $entity2], $ipNetwork->getEntities());
    }

    public function testCountry(): void
    {
        $ipNetwork = new IPNetwork();
        $country = 'country';
        $ipNetwork->setCountry($country);
        $this->assertSame($country, $ipNetwork->getCountry());
    }

    public function testHandle(): void
    {
        $ipNetwork = new IPNetwork();
        $handle = 'handle';
        $ipNetwork->setHandle($handle);
        $this->assertSame($handle, $ipNetwork->getHandle());
    }

    public function testParentHandle(): void
    {
        $ipNetwork = new IPNetwork();
        $handle = 'handle';
        $ipNetwork->setParentHandle($handle);
        $this->assertSame($handle, $ipNetwork->getParentHandle());
    }
}
