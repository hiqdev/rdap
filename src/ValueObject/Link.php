<?php declare(strict_types=1);

namespace hiqdev\rdap\core\ValueObject;

use League\Uri\AbstractUri;

/**
 * Class Link
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 *
 * @psalm-suppress DeprecatedInterface
 */
final class Link extends AbstractUri
{
    /**
     * Link constructor.
     * @param string|null $scheme
     * @param string|null $user
     * @param string|null $pass
     * @param string|null $host
     * @param int|null $port
     * @param string $path
     * @param string|null $query
     * @param string|null $fragment
     */
    public function __construct(string $scheme = null, string $user = null, string $pass = null, string $host = null, int $port = null, string $path = '', string $query = null, string $fragment = null)
    {
        parent::__construct($scheme, $user, $pass, $host, $port, $path, $query, $fragment);
    }

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
