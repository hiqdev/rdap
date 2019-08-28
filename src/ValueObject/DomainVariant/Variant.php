<?php

namespace hiqdev\rdap\core\ValueObject\DomainVariant;

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
     * @param array $relations
     * @param string $idnTable
     * @param array $variantNames
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
