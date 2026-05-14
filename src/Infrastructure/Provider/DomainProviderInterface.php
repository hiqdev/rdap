<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Provider;

use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Infrastructure\Exception\ObjectNotAvailableException;

/** Contract for assembling a complete RDAP Domain entity for a given domain name. */
interface DomainProviderInterface
{
    /** @throws ObjectNotAvailableException if domain was not found */
    public function get(DomainName $domainName): Domain;
}

