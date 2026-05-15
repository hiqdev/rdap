<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Infrastructure\DTO;

use hiqdev\rdap\core\Infrastructure\DTO\ContactData;
use PHPUnit\Framework\TestCase;

class ContactDataTest extends TestCase
{
    private function make(array $override = []): ContactData
    {
        $defaults = [
            'id'             => 'C-12345',
            'role'           => 'registrant',
            'whoisProtected' => false,
            'company'        => 'Acme Corp',
            'fullName'       => 'John Doe',
            'email'          => 'john@example.com',
            'street'         => '123 Main St',
            'city'           => 'Springfield',
            'province'       => 'IL',
            'postalCode'     => '62701',
            'country'        => 'US',
            'phone'          => '+1.8005550100',
        ];
        $p = array_merge($defaults, $override);

        return new ContactData(
            $p['id'],
            $p['role'],
            $p['whoisProtected'],
            $p['company'],
            $p['fullName'],
            $p['email'],
            $p['street'],
            $p['city'],
            $p['province'],
            $p['postalCode'],
            $p['country'],
            $p['phone']
        );
    }

    public function testGetters(): void
    {
        $c = $this->make();
        $this->assertSame('C-12345',         $c->getId());
        $this->assertSame('registrant',      $c->getRole());
        $this->assertFalse($c->isWhoisProtected());
        $this->assertSame('Acme Corp',       $c->getCompany());
        $this->assertSame('John Doe',        $c->getFullName());
        $this->assertSame('john@example.com', $c->getEmail());
        $this->assertSame('123 Main St',     $c->getStreet());
        $this->assertSame('Springfield',     $c->getCity());
        $this->assertSame('IL',              $c->getProvince());
        $this->assertSame('62701',           $c->getPostalCode());
        $this->assertSame('US',              $c->getCountry());
        $this->assertSame('+1.8005550100',   $c->getPhone());
    }

    public function testWhoisProtectedTrue(): void
    {
        $c = $this->make(['whoisProtected' => true]);
        $this->assertTrue($c->isWhoisProtected());
    }

    public function testRoleTechnical(): void
    {
        $c = $this->make(['role' => 'technical']);
        $this->assertSame('technical', $c->getRole());
    }

    public function testEmptyOptionalFields(): void
    {
        $c = $this->make(['company' => '', 'province' => '']);
        $this->assertSame('', $c->getCompany());
        $this->assertSame('', $c->getProvince());
    }
}
