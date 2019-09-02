<?php

namespace hiqdev\rdap\core\Infrastructure\Provider;

use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Infrastructure\Exception\ObjectNotAvailableException;

/**
 * Interface DomainProviderInterface
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
interface DomainProviderInterface
{
    /**
     * @param DomainName $domainName
     * @throws ObjectNotAvailableException if domain was not found
     */
    public function get(DomainName $domainName): Domain;
}

