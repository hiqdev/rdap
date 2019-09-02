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

final class Notice
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
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
    public function __construct(string $title, string $type, array $description, array $links = [])
    {
        $this->title = $title;
        $this->type = $type;
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
    public function getType(): string
    {
        return $this->type;
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
