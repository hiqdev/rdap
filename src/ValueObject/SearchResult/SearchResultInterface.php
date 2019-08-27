<?php


namespace hiqdev\rdap\core\ValueObject\SearchResult;

use hiqdev\rdap\core\Entity\Domain;
use hiqdev\rdap\core\Entity\Entity;
use hiqdev\rdap\core\Entity\Nameserver;

/**
 * Interface SearchResultInterface
 * @package hiqdev\rdap\core\ValueObject\SearchResult
 */
interface SearchResultInterface
{
    /**
     * AbstractSearchResult constructor.
     * @param Nameserver[]|Entity[]|Domain[] $valueSearchResults
     */
    public function __construct(array $valueSearchResults);

    /**
     * @param string $conformance
     */
    public function addRdapConformance(string $conformance): void;
}
