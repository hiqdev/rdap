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

/**
 * Class Link.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class Link
{
    /**
     * @var string|null
     * "value" : "http://example.com/context_uri"
     */
    private $value;

    /**
     * @var string|null
     * "rel" : "self" | "up"
     */
    private $rel;
    /**
     * @var string
     * "href" : "http://example.com/target_uri",
     */
    private $href;
    /**
     * @var string[]|null
     * "hreflang" : [ "en", "ch" ],
     */
    private $hreflang;
    /**
     * @var string|null
     * "title" : "title",
     */
    private $title;
    /**
     * @var string|null
     * "media" : "screen",
     */
    private $media;
    /**
     * @var string|null
     * "type" : "application/json"
     */
    private $type;

    /**
     * Link constructor.
     * @param string $href
     */
    public function __construct(string $href)
    {
        $this->href = $href;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
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
    public function getMedia(): ?string
    {
        return $this->media;
    }

    /**
     * @param string $media
     */
    public function setMedia(string $media): void
    {
        $this->media = $media;
    }

    /**
     * @return string[]|null
     */
    public function getHreflang(): ?array
    {
        return $this->hreflang;
    }

    /**
     * @param string $hrefLang
     * @return Link
     */
    public function addHrefLang(string $hrefLang): self
    {
        if (empty($this->hreflang)) {
            $this->hreflang = [];
        }
        $this->hreflang[] = $hrefLang;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return string|null
     */
    public function getRel(): ?string
    {
        return $this->rel;
    }

    /**
     * @param string $rel
     */
    public function setRel(string $rel): void
    {
        $this->rel = $rel;
    }

    /**
     * Tell whether the current URI is in valid state.
     *
     * The URI object validity depends on the scheme. This method
     * MUST be implemented on every URI object
     */
    private function isValidUri(): bool
    {
        return true;
    }
}
