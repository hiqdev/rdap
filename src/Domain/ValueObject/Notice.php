<?php

declare(strict_types=1);
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Domain\ValueObject;

/** RDAP notice or remark value object (RFC 9083 §4.3), containing a title, optional type, description lines, and related links. */
final class Notice
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string||null
     */
    private $type;

    /**
     * @var string[]
     */
    private $description;

    /**
     * @var Link[]
     */
    private $links;

    /**
     * Notice constructor.
     *
     * @param string $title
     * @param string $type
     * @param string[] $description
     * @param Link[] $links
     */
    public function __construct(string $title, array $description, array $links = [])
    {
        $this->title = $title;
        $this->description = $description;
        $this->links = $links;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type ?? null;
    }

    /**
     * @param  string|null $type Optional notice type identifier
     * @return self
     */
    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getDescription(): array
    {
        return $this->description;
    }

    /**
     * @return Link[]
     */
    public function getLinks(): array
    {
        return $this->links;
    }
}
