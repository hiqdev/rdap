<?php


namespace hiqdev\rdap\core\ValueObject\SecureDNS;


use hiqdev\rdap\core\ValueObject\Link;
use hiqdev\rdap\core\ValueObject\Event;

abstract class AbstractData
{
    /**
     * @var Event[]
     */
    protected $events;

    /**
     * @var Link[]
     */
    protected $links;

    /**
     * @var int
     */
    protected $algorythm;

    /**
     * AbstractData constructor.
     * @param Event[] $events
     * @param Link[] $links
     * @param int $algorythm
     */
    public function __construct(array $events, array $links, int $algorythm)
    {
        $this->events = empty($events) ? [] : $events;
        $this->links = empty($links) ? [] : $links;
        $this->algorythm = $algorythm;
    }

    /**
     * @return int
     */
    public function getAlgorythm(): int
    {
        return $this->algorythm;
    }

    /**
     * @return Event[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @return Link[]
     */
    public function getLinks(): array
    {
        return $this->links;
    }
}
