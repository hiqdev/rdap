<?php declare(strict_types=1);

namespace hiqdev\rdap\core\Entity;

use hiqdev\rdap\core\Constant\ObjectClassName;
use hiqdev\rdap\core\Constant\Status;
use hiqdev\rdap\core\ValueObject\DomainName;
use hiqdev\rdap\core\ValueObject\Event;
use hiqdev\rdap\core\ValueObject\Notice;

abstract class Common
{
    public const DEFAULT_RDAP_CONFORMANCE = 'rdap_level_0';

    /**
     * @var string[] The data structure named "rdapConformance" is an array of strings,
     * each providing a hint as to the specifications used in the construction of the response.
     * This data structure appears only in the topmost JSON object of a response.
     */
    private $rdapConformance = [self::DEFAULT_RDAP_CONFORMANCE];

    /**
     * @var Link[]
     */
    private $links;

    /**
     * @var Notice[]
     */
    private $notices;

    /**
     * @var Notice[]
     */
    private $remarks;

    /**
     * @var string This data structure consists solely of a name/value pair, where the
     * name is "lang" and the value is a string containing a language
     * identifier as described in [RFC5646]
     */
    private $lang;

    /**
     * @var ObjectClassName
     */
    private $objectClassName;

    /**
     * @var Event[]
     */
    private $events;

    /**
     * @var DomainName
     */
    private $port43;
    /**
     * @var Status[]
     */
    private $status;

    public function __construct(
        array $links,
        array $notices,
        array $remarks,
        string $lang,
        ObjectClassName $objectClassName,
        array $events,
        array $status,
        DomainName $port43
    ) {
        $this->links = $links;
        $this->notices = $notices;
        $this->remarks = $remarks;
        $this->lang = $lang;
        $this->objectClassName = $objectClassName;
        $this->events = $events;
        $this->status = $status;
        $this->port43 = $port43;
    }

    /**
     * @return string[]
     */
    public function getRdapConformance(): array
    {
        return $this->rdapConformance;
    }

    /**
     * @return Link[]
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @return Notice[]
     */
    public function getNotices(): array
    {
        return $this->notices;
    }

    /**
     * @return Notice[]
     */
    public function getRemarks(): array
    {
        return $this->remarks;
    }

    /**
     * @return string
     */
    public function getLang(): string
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
     * @return Event[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @return DomainName
     */
    public function getPort43(): DomainName
    {
        return $this->port43;
    }

    /**
     * @return Status[]
     */
    public function getStatus(): array
    {
        return $this->status;
    }
}
