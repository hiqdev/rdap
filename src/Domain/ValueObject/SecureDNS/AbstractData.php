<?php
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Domain\ValueObject\SecureDNS;

use hiqdev\rdap\core\Domain\ValueObject\Event;
use hiqdev\rdap\core\Domain\ValueObject\Link;

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
