<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Query;

/**
 * Query object for fetching domain names that need RDAP cache updates.
 *
 * Carries three optional filters: whether to include unchanged domains,
 * a row limit, and a specific list of domain names to restrict the query to.
 */
final class DomainNamesQuery
{
    /** @var bool|null */
    private $include;

    /** @var int|null */
    private $limit;

    /** @var array|null */
    private $domains;

    /**
     * @param  bool|null $include When true, include domains whose RDAP data has not changed since last pack
     * @return self
     */
    public function setIncludeNotChanged(?bool $include): self
    {
        $this->include = $include;
        return $this;
    }

    /** @return bool|null True to include unchanged domains; null means default (changed only) */
    public function getIncludeNotChanged(): ?bool
    {
        return $this->include;
    }

    /**
     * @param  int|null $limit Maximum number of domain names to return; null means no limit
     * @return self
     */
    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /** @return int|null Row limit, or null for unlimited */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @param  array|null $domains Restrict results to these domain names; null means all domains
     * @return self
     */
    public function setDomains(?array $domains = null): self
    {
        $this->domains = $domains;
        return $this;
    }

    /** @return array|null Specific domain names to query, or null for no restriction */
    public function getDomains(): ?array
    {
        return $this->domains;
    }
}
