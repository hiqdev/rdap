<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Domain\Entity;

use hiqdev\rdap\core\Domain\Entity\VCard;
use PHPUnit\Framework\TestCase;

class VCardTest extends TestCase
{
    public function testDefaultVersionIsSet(): void
    {
        $vcard = new VCard();
        $data  = $vcard->jsonSerialize();
        $this->assertSame('version', $data[0][0]);
        $this->assertSame('4.0', $data[0][3]);
    }

    public function testSetFullName(): void
    {
        $vcard = new VCard();
        $vcard->setFullName('John Doe');
        $found = $this->findProp($vcard->jsonSerialize(), 'fn');
        $this->assertNotNull($found);
        $this->assertSame('John Doe', $found[3]);
        $this->assertSame('text', $found[2]);
    }

    public function testSetName(): void
    {
        $vcard = new VCard();
        $vcard->setName('Doe;John');
        $found = $this->findProp($vcard->jsonSerialize(), 'n');
        $this->assertSame('Doe;John', $found[3]);
    }

    public function testSetEmail(): void
    {
        $vcard = new VCard();
        $vcard->setEmail('john@example.com');
        $found = $this->findProp($vcard->jsonSerialize(), 'email');
        $this->assertSame('john@example.com', $found[3]);
    }

    public function testSetOrg(): void
    {
        $vcard = new VCard();
        $vcard->setOrg('Acme Corp');
        $found = $this->findProp($vcard->jsonSerialize(), 'org');
        $this->assertSame('Acme Corp', $found[3]);
    }

    public function testSetOrgEmptyIsNoop(): void
    {
        $vcard = new VCard();
        $vcard->setOrg('');
        $this->assertNull($this->findProp($vcard->jsonSerialize(), 'org'));
    }

    public function testSetOrgNullIsNoop(): void
    {
        $vcard = new VCard();
        $vcard->setOrg(null);
        $this->assertNull($this->findProp($vcard->jsonSerialize(), 'org'));
    }

    public function testSetCompanyAliasesSetOrg(): void
    {
        $vcard = new VCard();
        $vcard->setCompany('Initech');
        $found = $this->findProp($vcard->jsonSerialize(), 'org');
        $this->assertSame('Initech', $found[3]);
    }

    public function testSetUrl(): void
    {
        $vcard = new VCard();
        $vcard->setUrl('https://example.com');
        $found = $this->findProp($vcard->jsonSerialize(), 'url');
        $this->assertSame('https://example.com', $found[3]);
        $this->assertSame('uri', $found[2]);
    }

    public function testSetTelDefaultsToVoice(): void
    {
        $vcard = new VCard();
        $vcard->setTel('+1-800-555-0100');
        $found = $this->findProp($vcard->jsonSerialize(), 'tel');
        $this->assertSame('+1-800-555-0100', $found[3]);
        $this->assertSame('voice', $found[1]['type']);
    }

    public function testSetTelCustomType(): void
    {
        $vcard = new VCard();
        $vcard->setTel('+1-800-555-0200', ['type' => 'fax']);
        $found = $this->findProp($vcard->jsonSerialize(), 'tel');
        $this->assertSame('fax', $found[1]['type']);
    }

    public function testSetAddress(): void
    {
        $vcard = new VCard();
        $vcard->setAddress('123 Main St', 'Springfield', '62701', 'US', 'IL');
        $found = $this->findProp($vcard->jsonSerialize(), 'adr');
        $this->assertNotNull($found);
        $addrParts = $found[3];
        $this->assertSame('123 Main St', $addrParts[2]);
        $this->assertSame('Springfield', $addrParts[3]);
        $this->assertSame('62701', $addrParts[5]);
    }

    public function testSetAddressCountryCodeUppercased(): void
    {
        $vcard = new VCard();
        $vcard->setAddress('1 Rue', 'Paris', '75001', 'fr');
        $found = $this->findProp($vcard->jsonSerialize(), 'adr');
        $this->assertSame('FR', $found[1]['cc']);
    }

    public function testGetVCard(): void
    {
        $vcard = new VCard();
        $vcard->setFullName('Alice');
        $this->assertIsArray($vcard->getVCard());
        $this->assertArrayHasKey('fn', $vcard->getVCard());
    }

    public function testJsonSerializeReturnsIndexedArray(): void
    {
        $vcard = new VCard();
        $vcard->setFullName('Bob');
        $data = $vcard->jsonSerialize();
        $this->assertIsArray($data);
        $this->assertArrayHasKey(0, $data);
    }

    public function testConstructorMergesInitialProperties(): void
    {
        $initial = [
            ['fn', new \stdClass(), 'text', 'Preset Name'],
        ];
        $vcard = new VCard($initial);
        $found = $this->findProp($vcard->jsonSerialize(), 'fn');
        $this->assertSame('Preset Name', $found[3]);
    }

    private function findProp(array $props, string $name): ?array
    {
        foreach ($props as $p) {
            if ($p[0] === $name) {
                return $p;
            }
        }
        return null;
    }
}
