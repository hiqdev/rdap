<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Domain\ValueObject;

use hiqdev\rdap\core\Domain\Constant\Relation;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Domain\ValueObject\DomainVariant\Name;
use hiqdev\rdap\core\Domain\ValueObject\DomainVariant\Variant;
use PHPUnit\Framework\TestCase;

class DomainVariantTest extends TestCase
{
    // --- Name ---

    public function testNameGetters(): void
    {
        $ldh     = DomainName::of('xn--nxasmq6b.com');
        $unicode = DomainName::of('παράδειγμα.com');
        $name    = new Name($ldh, $unicode);

        $this->assertSame($ldh, $name->getLdhName());
        $this->assertSame($unicode, $name->getUnicodeName());
    }

    public function testNameWithSameLdhAndUnicode(): void
    {
        $dn   = DomainName::of('example.com');
        $name = new Name($dn, $dn);

        $this->assertSame((string) $dn, (string) $name->getLdhName());
        $this->assertSame((string) $dn, (string) $name->getUnicodeName());
    }

    // --- Variant ---

    public function testVariantGetters(): void
    {
        $name1    = new Name(DomainName::of('example.com'), DomainName::of('example.com'));
        $name2    = new Name(DomainName::of('xn--nxasmq6b.com'), DomainName::of('παράδειγμα.com'));
        $relation = Relation::REGISTERED;
        $variant  = new Variant([$relation], '.EXAMPLE IDN Table', [$name1, $name2]);

        $this->assertSame([$relation], $variant->getRelations());
        $this->assertSame('.EXAMPLE IDN Table', $variant->getIdnTable());
        $this->assertCount(2, $variant->getVariantNames());
        $this->assertSame($name1, $variant->getVariantNames()[0]);
        $this->assertSame($name2, $variant->getVariantNames()[1]);
    }

    public function testVariantDefaultEmptyNames(): void
    {
        $variant = new Variant([], 'table');
        $this->assertSame([], $variant->getVariantNames());
        $this->assertSame([], $variant->getRelations());
    }

    public function testVariantMultipleRelations(): void
    {
        $variant = new Variant([Relation::REGISTERED, Relation::CONJOINED], 'table');
        $this->assertCount(2, $variant->getRelations());
        $this->assertSame(Relation::REGISTERED, $variant->getRelations()[0]);
        $this->assertSame(Relation::CONJOINED, $variant->getRelations()[1]);
    }
}
