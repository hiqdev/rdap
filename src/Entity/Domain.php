<?php

namespace hiqdev\rdap\core\Entity;

use hiqdev\rdap\core\ValueObject\DomainVariant\Variant;
use hiqdev\rdap\core\ValueObject\PublicId;

final class Domain extends Common
{
    /**
     * @var PublicId[]
     */
    private $publicIds = [];

    /**
     * @var string a string representing a registry unique identifier of the entity
     */
    private $handle;

    /**
     * @var Variant[]
     */
    private $variants;

    /**
     * @var Nameserver[]
     */
    private $nameservers;

    /**
     * @var SecureDNS
     */
    private $secureDNS;

    /**
     * @var Entity[]
     */
    private $entities;

    /**
     * @var IPNetwork
     */
    private $network;

    public function __construct()
    {

    }
}
