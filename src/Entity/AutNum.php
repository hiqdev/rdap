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

    public function __construct(
        string $handle,
        int $startAutnum,
        int $endAutnum,
        string $name,
        string $type,
        string $country
    ) {
        parent::__construct(ObjectClassName::AUTNUM());
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getType(): string
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getEndAutnum(): int
    {
        return $this->endAutnum;
    }

    /**
     * @return int
     */
    public function getStartAutnum(): int
    {
        return $this->startAutnum;
    }
}
