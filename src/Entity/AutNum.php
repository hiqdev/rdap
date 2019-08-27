<?php


namespace hiqdev\rdap\core\Entity;


use hiqdev\rdap\core\Constant\ObjectClassName;
use hiqdev\rdap\core\ValueObject\DomainName;

final class AutNum extends Common
{
    public const OBJECT_CLASS_NAME = 'autnum';

    /**
     * @var string|null a string representing a registry unique identifier of the entity
     */
    private $handle;

    /**
     * @var int
     */
    private $startAutnum;

    /**
     * @var int
     */
    private $endAutnum;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $country;

    public function __construct()
    {
        parent::__construct(ObjectClassName::AUTNUM());
    }
}
