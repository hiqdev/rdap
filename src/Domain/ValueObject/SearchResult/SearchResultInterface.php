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

/**
 * Interface SearchResultInterface.
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
