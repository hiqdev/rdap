<?php declare(strict_types=1);

namespace hiqdev\rdap\core\Entity;

use hiqdev\rdap\core\ValueObject\DomainName;
use hiqdev\rdap\core\ValueObject\Event;
use hiqdev\rdap\core\ValueObject\Notice;

abstract class Common
{
    public const DEFAULT_RDAP_CONFORMANCE = 'rdap_level_0';

    /**
     * @var string[]
     */
    protected $rdapConformance;

    /**
     * @var Link[]
     */
    protected $links = [];

    /**
     * @var Notice[]
     */
    protected $notices = [];

    /**
     * @var Notice[]
     */
    protected $remarks = [];

    /**
     * @var string
     */
    public $lang;

    /**
     * @var string
     */
    public $objectClassName;

    /**
     * @var Event[]
     */
    public $events = [];

    /**
     * @var DomainName|null
     */
    public $port43;
}
