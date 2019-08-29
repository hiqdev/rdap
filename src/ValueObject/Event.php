<?php

declare(strict_types=1);
/**
 * Registration Data Access Protocol – core objects implemantation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\ValueObject;

use DateTimeImmutable;
use hiqdev\rdap\core\Constant\EventAction;

final class Event
{
    /**
     * @var EventAction a string denoting the reason for the event
     */
    private $action;
    /**
     * @var string|null an optional identifier denoting the actor
     * responsible for the event
     */
    private $actor;
    /**
     * @var DateTimeImmutable the time and date the event occurred
     */
    private $date;
    /**
     * @var Link[]
     */
    private $links = [];

    private function __construct(EventAction $action, DateTimeImmutable $date)
    {
        $this->action = $action;
        $this->date = $date;
    }

    public static function occurred(EventAction $action, DateTimeImmutable $date): self
    {
        return new self($action, $date);
    }

    /**
     * @param string $actor
     * @return Event
     */
    public function setActor(string $actor): self
    {
        $this->actor = $actor;

        return $this;
    }

    public function addLink(Link $link): self
    {
        $this->links[] = $link;

        return $this;
    }

    /**
     * @return EventAction
     */
    public function getAction(): EventAction
    {
        return $this->action;
    }

    /**
     * @return string|null
     */
    public function getActor(): ?string
    {
        return $this->actor;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return Link[]
     */
    public function getLinks(): array
    {
        return $this->links;
    }
}
