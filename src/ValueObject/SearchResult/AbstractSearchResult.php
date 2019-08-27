<?php


namespace hiqdev\rdap\core\ValueObject\SearchResult;


use hiqdev\rdap\core\Entity\Domain;
use hiqdev\rdap\core\Entity\Entity;
use hiqdev\rdap\core\Entity\Nameserver;

abstract class AbstractSearchResult implements SearchResultInterface
{
    /**
     * @var string
     */
    public $rdapConformance;

    /**
     * @var Nameserver[]|Entity[]|Domain[] $valueSearchResults
     */
    public $valueSearchResults;

    /**
     * @inheritDoc
     */
    public function __construct(array $valueSearchResults)
    {
        $this->valueSearchResults = $valueSearchResults;
    }

    /**
     * @inheritDoc
     */
    public function addRdapConformance(string $conformance): void
    {
        if (empty($this->rdapConformance)) {
            $this->rdapConformance = [];
        }
        $this->rdapConformance[] = $conformance;
    }
}
