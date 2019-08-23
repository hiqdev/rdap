<?php


namespace hiqdev\rdap\core\Entity;


use hiqdev\rdap\core\Constant\ObjectClassName;
use hiqdev\rdap\core\ValueObject\DomainName;

class Nameserver extends Common
{
    public const OBJECT_CLASS_NAME = "nameserver";

    /**
     * @var string
     */
    public $handle;

    /**
     * @var DomainName
     */
    public $ldhName;

    /**
     * @var DomainName
     */
    public $unicodeName;

    /**
     * @var IpAddresses
     */
    public $ipAddresses;

    public function __construct(
        array $links,
        array $notices,
        array $remarks,
        string $lang,
        ObjectClassName $objectClassName,
        array $events,
        array $status,
        DomainName $port43,
        string $handle,
        DomainName $ldhName,
        DomainName $unicodeName,
        IpAddresses $ipAddresses
    ) {
        parent::__construct(
            $links,
            $notices,
            $remarks,
            $lang,
            $objectClassName,
            $events,
            $status,
            $port43
        );
        $this->handle = $handle;
        $this->ldhName = $ldhName;
        $this->unicodeName = $unicodeName;
        $this->ipAddresses = $ipAddresses;
    }

    /**
     * @return string
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @return DomainName
     */
    public function getLdhName()
    {
        return $this->ldhName;
    }

    /**
     * @return DomainName
     */
    public function getUnicodeName()
    {
        return $this->unicodeName;
    }

    /**
     * @return IpAddresses
     */
    public function getIpAdresses()
    {
        return $this->ipAddresses;
    }
}
