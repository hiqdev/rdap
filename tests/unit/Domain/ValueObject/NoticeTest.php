<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Domain\ValueObject;

use hiqdev\rdap\core\Domain\ValueObject\Link;
use hiqdev\rdap\core\Domain\ValueObject\Notice;
use PHPUnit\Framework\TestCase;

class NoticeTest extends TestCase
{
    public function testConstruction(): void
    {
        $notice = new Notice('Terms of Use', 'result set truncated due to authorization', ['This is a description']);
        $this->assertSame('Terms of Use', $notice->getTitle());
        $this->assertSame('result set truncated due to authorization', $notice->getType());
        $this->assertSame(['This is a description'], $notice->getDescription());
        $this->assertSame([], $notice->getLinks());
    }

    public function testWithLinks(): void
    {
        $link = new Link('https://example.com/tos');
        $notice = new Notice('TOS', 'reference', ['See terms'], [$link]);
        $this->assertCount(1, $notice->getLinks());
        $this->assertSame('https://example.com/tos', $notice->getLinks()[0]->getHref());
    }

    public function testMultipleDescriptionLines(): void
    {
        $notice = new Notice('Info', 'type', ['Line 1', 'Line 2', 'Line 3']);
        $this->assertCount(3, $notice->getDescription());
    }
}
