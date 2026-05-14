<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Storage;

/**
 * Storage contract for pre-built RDAP JSON keyed by domain name.
 *
 * Implementations must handle save/find/delete and a time-based pruning operation.
 * How expiry is enforced (TTL, mtime scan, etc.) is left to each implementation.
 */
interface DomainInfoStorageInterface
{
    /** @param string $domainName Fully-qualified domain name used as the storage key */
    public function save(string $domainName, string $json): void;

    /**
     * @param  string $domainName Fully-qualified domain name
     * @return string|null Stored RDAP JSON, or null if not found
     */
    public function find(string $domainName): ?string;

    /** @param string $domainName Fully-qualified domain name whose record should be removed */
    public function delete(string $domainName): void;

    /** @param \DateTimeImmutable $threshold Remove all records that were not updated after this point in time */
    public function removeNotUpdatedSince(\DateTimeImmutable $threshold): void;
}
