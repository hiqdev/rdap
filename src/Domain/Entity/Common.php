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

namespace hiqdev\rdap\core\Domain\Entity;

use hiqdev\rdap\core\Domain\Constant\ObjectClassName;
use hiqdev\rdap\core\Domain\Constant\Status;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Domain\ValueObject\Event;
use hiqdev\rdap\core\Domain\ValueObject\Link;
use hiqdev\rdap\core\Domain\ValueObject\Notice;

/**
 * Abstract base for all RDAP top-level objects (RFC 9083 §4), providing common fields:
 * object class name, links, notices, remarks, language, events, port-43 hostname, and status.
 */
abstract class Common
{

    /**
     * @var ObjectClassName
     */
    private $objectClassName;

    /**
     * @var Link[]|null
     */
    private $links;

    /**
     * @var Notice[]|null
     */
    private $notices;

    /**
     * @var Notice[]|null
     */
    private $remarks;

    /**
     * @var string|null This data structure consists solely of a name/value pair, where the
     * name is "lang" and the value is a string containing a language
     * identifier as described in [RFC5646]
     */
    private $lang;

    /**
     * @var Event[]|null
     */
    private $events;

    /**
     * @var DomainName|null
     */
    private $port43;
    /**
     * @var Status[]|null
     */
    private $status;

    /** @param ObjectClassName $objectClassName RDAP object class for this entity */
    public function __construct(ObjectClassName $objectClassName)
    {
        $this->objectClassName = $objectClassName;
    }

    /**
     * @return Link[]|null
     */
    public function getLinks(): ?array
    {
        return $this->links;
    }

    /**
     * @return Notice[]|null
     */
    public function getNotices(): ?array
    {
        return $this->notices;
    }

    /**
     * @return Notice[]|null
     */
    public function getRemarks(): ?array
    {
        return $this->remarks;
    }

    /**
     * @return string|null
     */
    public function getLang(): ?string
    {
        return $this->lang;
    }

    /**
     * @return ObjectClassName
     */
    public function getObjectClassName(): ObjectClassName
    {
        return $this->objectClassName;
    }

    /**
     * @return Event[]|null
     */
    public function getEvents(): ?array
    {
        return $this->events;
    }

    /**
     * @return DomainName|null
     */
    public function getPort43(): ?DomainName
    {
        return $this->port43;
    }

    /**
     * @return Status[]|null
     */
    public function getStatus(): ?array
    {
        return $this->status;
    }

    /**
     * @param Link $link
     * @return Common
     */
    public function addLink(Link $link): Common
    {
        if ($this->links === null) {
            $this->links = [];
        }
        $this->links[] = $link;

        return $this;
    }

    /**
     * @param Notice $notice
     * @return Common
     */
    public function addNotice(Notice $notice): Common
    {
        if ($this->notices === null) {
            $this->notices = [];
        }
        $this->notices[] = $notice;

        return $this;
    }

    /**
     * @param Notice $remark
     * @return Common
     */
    public function addRemark(Notice $remark): Common
    {
        if ($this->remarks === null) {
            $this->remarks = [];
        }
        $this->remarks[] = $remark;

        return $this;
    }

    /**
     * @param string $lang
     * @return Common
     */
    public function setLang(string $lang): Common
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * @param Event $event
     * @return Common
     */
    public function addEvent(Event $event): Common
    {
        if ($this->events === null) {
            $this->events = [];
        }
        $this->events[] = $event;

        return $this;
    }

    /**
     * @param DomainName $port43
     * @return Common
     */
    public function setPort43(DomainName $port43): Common
    {
        $this->port43 = $port43;

        return $this;
    }

    /**
     * @param Status $status
     * @return Common
     */
    public function addStatus(Status $status): Common
    {
        if (empty($this->status)) {
            $this->status = [];
        }
        $this->status[] = $status;

        return $this;
    }
}
