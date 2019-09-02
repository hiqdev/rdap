<?php
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
use hiqdev\rdap\core\Domain\ValueObject\InetAddress;

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
    public function getParentHandle(): ?string
    {
        return $this->parentHandle;
    }

    /**
     * @param string|null $parentHandle
     */
    public function setParentHandle(?string $parentHandle): void
    {
        $this->parentHandle = $parentHandle;
    }

    /**
     * @return string|null
     */
    public function getHandle(): ?string
    {
        return $this->handle;
    }

    /**
     * @param string $handle
     */
    public function setHandle(string $handle): void
    {
        $this->handle = $handle;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     */
    public function setCountry(?string $country): void
    {
        $this->country = $country;
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

    /**
     * @return InetAddress|null
     */
    public function getEndAddress(): ?InetAddress
    {
        return $this->endAddress;
    }

    /**
     * @param InetAddress|null $startAddress
     */
    public function setStartAddress(?InetAddress $startAddress): void
    {
        $this->startAddress = $startAddress;
    }

    /**
     * @param Entity $entity
     */
    public function addEntity(Entity $entity): void
    {
        if (empty($this->entities)) {
            $this->entities = [];
        }
        $this->entities[] = $entity;
    }

    /**
     * @return Entity[]|null
     */
    public function getEntities(): ?array
    {
        return $this->entities;
    }
}
