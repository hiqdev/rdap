<?php

namespace hiqdev\rdap\core\Entity;

use hiqdev\rdap\core\Constant\ObjectClassName;
use hiqdev\rdap\core\ValueObject\DomainName;
use hiqdev\rdap\core\ValueObject\DomainVariant\Variant;
use hiqdev\rdap\core\ValueObject\PublicId;
use hiqdev\rdap\core\ValueObject\SecureDNS;

final class Domain extends Common
{
    /**
     * @var DomainName
     */
    private $ldhName;

    /**
     * @var PublicId[]|null
     */
    private $publicIds;

    /**
     * @var string|null a string representing a registry unique identifier of the entity
     */
    private $handle;

    /**
     * @var Variant[]|null
     */
    private $variants;

    /**
     * @var Nameserver[]|null
     */
    private $nameservers;

    /**
     * @var SecureDNS|null
     */
    private $secureDNS;

    /**
     * @var Entity[]|null
     */
    private $entities;

    /**
     * @var IPNetwork|null
     */
    private $network;

    public function __construct(DomainName $ldhName)
    {
        parent::__construct(ObjectClassName::DOMAIN());

        $this->ldhName = $ldhName;
    }

    /**
     * @return DomainName
     */
    public function getLdhName(): DomainName
    {
        return $this->ldhName;
    }

    /**
     * @return PublicId[]|null
     */
    public function getPublicIds(): ?array
    {
        return $this->publicIds;
    }

    /**
     * @return string|null
     */
    public function getHandle(): ?string
    {
        return $this->handle;
    }

    /**
     * @return Variant[]|null
     */
    public function getVariants(): ?array
    {
        return $this->variants;
    }

    /**
     * @return Nameserver[]|null
     */
    public function getNameservers(): ?array
    {
        return $this->nameservers;
    }

    /**
     * @return SecureDNS|null
     */
    public function getSecureDNS(): ?SecureDNS
    {
        return $this->secureDNS;
    }

    /**
     * @return Entity[]|null
     */
    public function getEntities(): ?array
    {
        return $this->entities;
    }

    /**
     * @return IPNetwork|null
     */
    public function getNetwork(): ?IPNetwork
    {
        return $this->network;
    }

    /**
     * @param PublicId $publicId
     * @return Domain
     */
    public function addPublicId(PublicId $publicId): Domain
    {
        if ($this->publicIds === null) {
            $this->publicIds = [];
        }
        $this->publicIds[] = $publicId;

        return $this;
    }

    /**
     * @param string $handle
     * @return Domain
     */
    public function setHandle(string $handle): Domain
    {
        $this->handle = $handle;

        return $this;
    }

    /**
     * @param Variant $variant
     * @return Domain
     */
    public function addVariant(Variant $variant): Domain
    {
        if ($this->variants === null) {
            $this->variants = [];
        }
        $this->variants[] = $variant;

        return $this;
    }

    /**
     * @param Nameserver $nameserver
     * @return Domain
     */
    public function addNameserver(Nameserver $nameserver): Domain
    {
        if ($this->nameservers === null) {
            $this->nameservers = [];
        }
        $this->nameservers[] = $nameserver;

        return $this;
    }

    /**
     * @param SecureDNS $secureDNS
     * @return Domain
     */
    public function setSecureDNS(SecureDNS $secureDNS): Domain
    {
        $this->secureDNS = $secureDNS;

        return $this;
    }

    /**
     * @param Entity $entity
     * @return Domain
     */
    public function addEntity(Entity $entity): Domain
    {
        if ($this->entities === null) {
            $this->entities = [];
        }
        $this->entities[] = $entity;

        return $this;
    }

    /**
     * @param IPNetwork $network
     * @return Domain
     */
    public function setNetwork(IPNetwork $network): Domain
    {
        $this->network = $network;

        return $this;
    }
}
