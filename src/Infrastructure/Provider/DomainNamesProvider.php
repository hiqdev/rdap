<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Provider;

use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use hiqdev\rdap\core\Infrastructure\Query\DomainNamesQuery;
use Iterator;

/**
 * Yields DomainName instances from the repository for a given query.
 *
 * Acts as a lazy iterator adapter over DomainNamesRepositoryInterface,
 * converting raw name strings to typed DomainName value objects.
 */
final class DomainNamesProvider
{
    /** @var DomainNamesRepositoryInterface */
    private $repository;

    /** @param DomainNamesRepositoryInterface $repository Data source for retrieving domain name lists */
    public function __construct(DomainNamesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /** @return Iterator which yields DomainName instances */
    public function byQuery(DomainNamesQuery $query): Iterator
    {
        foreach ($this->repository->findNamesByQuery($query) as $domain) {
            yield DomainName::of($domain['name']);
        }
    }
}
