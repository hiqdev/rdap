<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Provider;

use hiqdev\rdap\core\Infrastructure\Query\DomainNamesQuery;

interface DomainNamesRepositoryInterface
{
    /**
     * @param  DomainNamesQuery $query Filter / limit options for the domain name list
     * @return array<array{name: string}> Rows, each containing a "name" key with the domain name string
     */
    public function findNamesByQuery(DomainNamesQuery $query): array;
}
