<?php

declare(strict_types=1);
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Domain\ValueObject;

use DateTimeImmutable;
use hiqdev\rdap\core\Domain\Constant\EventAction;

final class Event
{
    /**
     * @var EventAction a string denoting the reason for the event
     */
    private $eventAction;
    /**
     * @var string|null an optional identifier denoting the actor
     * responsible for the event
     */
    private $eventActor;
    /**
     * @var DateTimeImmutable the time and date the event occurred
     */
    private $eventDate;
    /**
     * @var Link[]
     */
    private $links = [];

    private function __construct(EventAction $eventAction, DateTimeImmutable $eventDate)
    {
        $this->eventAction = $eventAction;
        $this->eventDate = $eventDate;
    }

    public static function occurred(EventAction $action, DateTimeImmutable $date): self
    {
        return new self($action, $date);
    }

    public function addLink(Link $link): self
    {
        $this->links[] = $link;

        return $this;
    }

    /**
     * @return EventAction
     */
    public function getEventAction(): EventAction
    {
        return $this->eventAction;
    }

    /**
     * @param string|null $eventActor
     */
    public function setEventActor(?string $eventActor): void
    {
        $this->eventActor = $eventActor;
    }

    /**
     * @return string|null
     */
    public function getEventActor(): ?string
    {
        return $this->eventActor;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEventDate(): DateTimeImmutable
    {
        return $this->eventDate;
    }

    /**
     * @return Link[]
     */
    public function getLinks(): array
    {
        return $this->links;
    }
}
