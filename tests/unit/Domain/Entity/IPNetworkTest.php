<?php
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\tests\unit\Domain\Entity;

use hiqdev\rdap\core\Domain\Constant\Status;
use hiqdev\rdap\core\Domain\Entity\Entity;
use hiqdev\rdap\core\Domain\Entity\IPNetwork;
use hiqdev\rdap\core\Domain\ValueObject\InetAddress;
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
        $entity1->addStatus(Status::OK());
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
