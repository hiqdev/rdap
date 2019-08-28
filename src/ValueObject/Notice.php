<?php declare(strict_types=1);

namespace hiqdev\rdap\core\ValueObject;

use hiqdev\rdap\core\ValueObject\Link;

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
     * @var string
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
     * @param string $description
     * @param Link[] $links
     */
    public function __construct(string $title, string $type, string $description, array $links = [])
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
     * @return string
     */
    public function getDescription(): string
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
