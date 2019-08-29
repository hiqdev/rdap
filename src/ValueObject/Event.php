<?php declare(strict_types=1);

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

    private function __construct()
    {
    }

    public static function occurred(EventAction $action, DateTimeImmutable $date): self
    {
        $event = new self();
        $event->action = $action;
        $event->date = $date;

        return $event;
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
