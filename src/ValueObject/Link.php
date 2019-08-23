<?php declare(strict_types=1);

namespace hiqdev\rdap\core\Entity;

use League\Uri\AbstractUri;

final class Link extends AbstractUri
{
    /**
     * Tell whether the current URI is in valid state.
     *
     * The URI object validity depends on the scheme. This method
     * MUST be implemented on every URI object
     */
    protected function isValidUri(): bool
    {
        return true;
    }
}
