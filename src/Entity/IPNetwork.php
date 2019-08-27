<?php


namespace hiqdev\rdap\core\Entity;


use hiqdev\rdap\core\Constant\ObjectClassName;
use hiqdev\rdap\core\ValueObject\InetAddress;

class IPNetwork extends Common
{
    /**
     * @var string|null a string representing a registry unique identifier of the entity
     */
    private $handle;

    /**
     * @var InetAddress|null
     */
    private $startAddress;

    /**
     * @var InetAddress|null
     */
    private $endAddress;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var string|null
     */
    private $country;

    /**
     * @var string|null
     */
    private $parentHandle;

    /**
     * @var Entity[]|null
     */
    private $entities;

    /**
     * IPNetwork constructor.
     */
    public function __construct()
    {
        parent::__construct(ObjectClassName::IPNETWORK());
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getHandle(): ?string
    {
        return $this->handle;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @return InetAddress|null
     */
    public function getStartAddress(): ?InetAddress
    {
        return $this->startAddress;
    }

    /**
     * @param InetAddress|null $endAddress
     */
    public function setEndAddress(?InetAddress $endAddress): void
    {
        $this->endAddress = $endAddress;
    }
}
