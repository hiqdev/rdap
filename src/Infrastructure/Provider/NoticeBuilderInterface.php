<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Provider;

use hiqdev\rdap\core\Domain\ValueObject\Notice;

/** Builds the RDAP Notice objects to embed in every domain response. */
interface NoticeBuilderInterface
{
    /**
     * @return Notice[]
     */
    public function build(string $currentUrl): array;
}
