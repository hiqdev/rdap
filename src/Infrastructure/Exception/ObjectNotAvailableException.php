<?php

namespace hiqdev\rdap\core\Infrastructure\Exception;

use Exception;
use hiqdev\rdap\core\Domain\Exception\RdapException;

/**
 * Class ObjectNotAvailableException
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class ObjectNotAvailableException extends Exception implements RdapException
{
}
