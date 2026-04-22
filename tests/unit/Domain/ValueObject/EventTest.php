<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\tests\unit\Domain\ValueObject;

use DateTimeImmutable;
use hiqdev\rdap\core\Domain\Constant\EventAction;
use hiqdev\rdap\core\Domain\ValueObject\Event;
use hiqdev\rdap\core\Domain\ValueObject\Link;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    public function testOccurred(): void
    {
        $date = new DateTimeImmutable('2024-01-15T10:30:00Z');
        $event = Event::occurred(EventAction::REGISTRATION(), $date);
        $this->assertSame(EventAction::REGISTRATION(), $event->getEventAction());
        $this->assertSame($date, $event->getEventDate());
        $this->assertNull($event->getEventActor());
        $this->assertSame([], $event->getLinks());
    }

    public function testEventActor(): void
    {
        $event = Event::occurred(EventAction::LAST_CHANGED(), new DateTimeImmutable());
        $event->setEventActor('registrar-x');
        $this->assertSame('registrar-x', $event->getEventActor());
    }

    public function testEventActorNullable(): void
    {
        $event = Event::occurred(EventAction::EXPIRATION(), new DateTimeImmutable());
        $event->setEventActor('actor');
        $event->setEventActor(null);
        $this->assertNull($event->getEventActor());
    }

    public function testAddLinks(): void
    {
        $event = Event::occurred(EventAction::REGISTRATION(), new DateTimeImmutable());
        $link1 = new Link('https://example.com/1');
        $link2 = new Link('https://example.com/2');
        $result = $event->addLink($link1);
        $this->assertSame($event, $result);
        $event->addLink($link2);
        $this->assertSame([$link1, $link2], $event->getLinks());
    }
}
