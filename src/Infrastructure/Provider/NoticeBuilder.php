<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Provider;

use hiqdev\rdap\core\Domain\ValueObject\Link;
use hiqdev\rdap\core\Domain\ValueObject\Notice;

/**
 * Builds RDAP Notice objects from a static configuration array.
 *
 * Each config entry must contain title, description, and link keys.
 * The link's value field is set to the current domain URL at build time.
 */
final class NoticeBuilder implements NoticeBuilderInterface
{
    /** @param array $noticesConfig Array of notice config entries with title, description, and link keys */
    public function __construct(private array $noticesConfig)
    {
    }

    /**
     * @return Notice[]
     */
    public function build(string $currentUrl): array
    {
        $notices = [];
        foreach ($this->noticesConfig as $config) {
            $link = new Link($config['link']['href']);
            $link->setType('text/html');
            $link->setValue($currentUrl);
            $link->setRel($config['link']['rel']);
            $notices[] = new Notice($config['title'], [$config['description']], [$link]);
        }

        return $notices;
    }
}
