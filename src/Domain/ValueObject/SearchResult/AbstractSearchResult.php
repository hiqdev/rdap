<?php
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Domain\ValueObject\SearchResult;

use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\Entity\Entity;
use hiqdev\rdap\core\Domain\Entity\Nameserver;

abstract class AbstractSearchResult implements SearchResultInterface
{
    /**
     * @var string[]
     */
    public $rdapConformance = [];

    /**
     * @var Nameserver[]|Entity[]|Domain[] $valueSearchResults
     */
    public $valueSearchResults;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $valueSearchResults)
    {
        $this->valueSearchResults = $valueSearchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function addRdapConformance(string $conformance): void
    {
        if (empty($this->rdapConformance)) {
            $this->rdapConformance = [];
        }
        $this->rdapConformance[] = $conformance;
    }
}
