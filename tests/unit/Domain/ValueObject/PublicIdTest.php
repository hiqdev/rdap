<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Domain\ValueObject;

use hiqdev\rdap\core\Domain\ValueObject\PublicId;
use PHPUnit\Framework\TestCase;

class PublicIdTest extends TestCase
{
    public function testConstruction(): void
    {
        $publicId = new PublicId('IANA Registrar ID', '1');
        $this->assertSame('IANA Registrar ID', $publicId->getType());
        $this->assertSame('1', $publicId->getIdentifier());
    }
}
