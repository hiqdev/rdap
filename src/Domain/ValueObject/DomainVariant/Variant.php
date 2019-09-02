<?php
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Domain\ValueObject\DomainVariant;

use hiqdev\rdap\core\Domain\Constant\Relation;

final class Variant
{
    /**
     * @var Relation[] an array of objects, with each object
     * containing an "ldhName" member and a "unicodeName" member
     */
    private $relations;

    /**
     * @var string the name of the Internationalized Domain Name (IDN)
     * table of codepoints, such as one listed with the IANA
     */
    private $idnTable;

    /**
     * @var Name[]
     */
    private $variantNames;

    /**
     * Variant constructor.
     *
     * @param Relation[] $relations
     * @param string $idnTable
     * @param Name[] $variantNames
     */
    public function __construct(array $relations, string $idnTable, array $variantNames = [])
    {
        $this->relations = $relations;
        $this->idnTable = $idnTable;
        $this->variantNames = $variantNames;
    }

    /**
     * @return Relation[]
     */
    public function getRelations(): array
    {
        return $this->relations;
    }

    /**
     * @return string
     */
    public function getIdnTable(): string
    {
        return $this->idnTable;
    }

    /**
     * @return Name[]
     */
    public function getVariantNames(): array
    {
        return $this->variantNames;
    }
}
