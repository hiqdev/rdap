<?php


namespace hiqdev\rdap\core\tests\unit\Domain\Entity;


use hiqdev\rdap\core\Entity\AutNum;
use PHPUnit\Framework\TestCase;

class AutnumTest extends TestCase
{
    public function testHandle(): void
    {
        $autnum = new Autnum();
        $handle = 'handle';
        $autnum->setHandle($handle);
        $this->assertSame($handle, $autnum->getHandle());
    }

    public function testCountry(): void
    {
        $autnum = new Autnum();
        $country = 'country';
        $autnum->setCountry($country);
        $this->assertSame($country, $autnum->getCountry());
    }

    public function testAutnums(): void
    {
        $startAutnum = 10;
        $endAutnum = 20;
        $autnum = new Autnum();
        $autnum->setStartAutnum($startAutnum);
        $this->assertSame($startAutnum, $autnum->getStartAutnum());
        $autnum->setEndAutnum($endAutnum);
        $this->assertSame($endAutnum, $autnum->getEndAutnum());
    }

    public function testTypeAndName(): void
    {
        $type = 'type';
        $name = 'name';
        $autnum = new Autnum();
        $autnum->setType($type);
        $this->assertSame($type, $autnum->getType());
        $autnum->setName($name);
        $this->assertSame($name, $autnum->getName());
    }
}
