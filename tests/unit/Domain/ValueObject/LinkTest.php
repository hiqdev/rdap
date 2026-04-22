<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Domain\ValueObject;

use hiqdev\rdap\core\Domain\ValueObject\Link;
use PHPUnit\Framework\TestCase;

class LinkTest extends TestCase
{
    public function testConstruction(): void
    {
        $link = new Link('https://example.com');
        $this->assertSame('https://example.com', $link->getHref());
        $this->assertNull($link->getType());
        $this->assertNull($link->getTitle());
        $this->assertNull($link->getMedia());
        $this->assertNull($link->getRel());
        $this->assertNull($link->getValue());
        $this->assertNull($link->getHreflang());
    }

    public function testSetters(): void
    {
        $link = new Link('https://example.com/rdap');
        $link->setType('application/rdap+json');
        $link->setTitle('RDAP Response');
        $link->setMedia('screen');
        $link->setRel('self');
        $link->setValue('https://example.com/context');

        $this->assertSame('application/rdap+json', $link->getType());
        $this->assertSame('RDAP Response', $link->getTitle());
        $this->assertSame('screen', $link->getMedia());
        $this->assertSame('self', $link->getRel());
        $this->assertSame('https://example.com/context', $link->getValue());
    }

    public function testHrefLang(): void
    {
        $link = new Link('https://example.com');
        $result = $link->addHrefLang('en');
        $this->assertSame($link, $result);
        $link->addHrefLang('uk');
        $this->assertSame(['en', 'uk'], $link->getHreflang());
    }
}
