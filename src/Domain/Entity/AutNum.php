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

final class AutNum extends Common
{
    public const OBJECT_CLASS_NAME = 'autnum';

    /**
     * @var string|null a string representing a registry unique identifier of the entity
     */
    private $handle;

    /**
     * @var int|null
     */
    private $startAutnum;

    /**
     * @var int|null
     */
    private $endAutnum;

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
     * AutNum constructor.
     */
    public function __construct()
    {
        parent::__construct(ObjectClassName::AUTNUM());
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
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
     * @param string|null $handle
     */
    public function setHandle(?string $handle): void
    {
        $this->handle = $handle;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getEndAutnum(): ?int
    {
        return $this->endAutnum;
    }

    /**
     * @return int|null
     */
    public function getStartAutnum(): ?int
    {
        return $this->startAutnum;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param int $startAutnum
     */
    public function setStartAutnum(int $startAutnum): void
    {
        $this->startAutnum = $startAutnum;
    }

    /**
     * @param int $endAutnum
     */
    public function setEndAutnum(int $endAutnum): void
    {
        $this->endAutnum = $endAutnum;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }
}
