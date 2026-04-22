<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Domain\ValueObject\Label;

use hiqdev\rdap\core\Domain\ValueObject\Label\ASCIILabel;
use hiqdev\rdap\core\Domain\ValueObject\Label\Label;
use hiqdev\rdap\core\Domain\ValueObject\Label\LDHLabel;
use hiqdev\rdap\core\Domain\ValueObject\Label\NonASCIILabel;
use hiqdev\rdap\core\Domain\ValueObject\Label\RootLabel;
use InvalidArgumentException;
use OutOfRangeException;
use PHPUnit\Framework\TestCase;

class LabelTest extends TestCase
{
    public function testOfASCII(): void
    {
        $label = Label::of('example');
        $this->assertInstanceOf(LDHLabel::class, $label);
        $this->assertSame('example', $label->getValue());
        $this->assertSame('example', (string) $label);
    }

    public function testOfEmpty(): void
    {
        $label = Label::of('');
        $this->assertInstanceOf(RootLabel::class, $label);
    }

    public function testOfNonASCII(): void
    {
        $label = Label::of('тест');
        $this->assertInstanceOf(NonASCIILabel::class, $label);
        $this->assertSame('тест', $label->getValue());
    }

    public function testLDHValid(): void
    {
        $label = new LDHLabel('example-1');
        $this->assertSame('example-1', $label->getValue());
    }

    public function testLDHInvalidCharacters(): void
    {
        $this->expectException(OutOfRangeException::class);
        new LDHLabel('exam_ple');
    }

    public function testLDHRejectsNonASCII(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new LDHLabel('тест');
    }

    public function testRootLabelSingleton(): void
    {
        $root1 = RootLabel::getInstance();
        $root2 = RootLabel::getInstance();
        $this->assertSame($root1, $root2);
        $this->assertSame('', (string) $root1);
    }

    public function testToLDH(): void
    {
        $label = new NonASCIILabel('тест');
        $ldh = $label->toLDH();
        $this->assertInstanceOf(LDHLabel::class, $ldh);
        $this->assertSame('xn--e1aybc', (string) $ldh);
    }

    public function testToUnicode(): void
    {
        $label = new LDHLabel('xn--e1aybc');
        $unicode = $label->toUnicode();
        $this->assertInstanceOf(NonASCIILabel::class, $unicode);
        $this->assertSame('тест', (string) $unicode);
    }

    public function testASCIICheckContains(): void
    {
        $this->assertTrue(ASCIILabel::checkContains('hello'));
        $this->assertTrue(ASCIILabel::checkContains('test-123'));
        $this->assertFalse(ASCIILabel::checkContains('тест'));
        $this->assertFalse(ASCIILabel::checkContains('café'));
    }
}
