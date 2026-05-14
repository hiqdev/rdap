<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Provider;

use hiqdev\rdap\core\Infrastructure\DTO\ContactDataInterface;
use hiqdev\rdap\core\Infrastructure\DTO\DnsSecDataInterface;
use hiqdev\rdap\core\Infrastructure\DTO\DomainDataInterface;
use hiqdev\rdap\core\Infrastructure\Exception\ObjectNotAvailableException;

/**
 * Data access contract for fetching domain registration data from the registry.
 *
 * Provides separate methods for domain metadata, contact list, and DS records
 * so that callers can skip the DS query when delegationSigned is false.
 */
interface DomainRepositoryInterface
{
    /** @throws ObjectNotAvailableException if domain was not found */
    public function findDomainByName(string $name): DomainDataInterface;

    /** @return ContactDataInterface[] */
    public function findContactsByDomainName(string $name): array;

    /** @return DnsSecDataInterface[] */
    public function findSecDnsByDomainName(string $name): array;
}
