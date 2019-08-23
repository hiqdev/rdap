<?php

namespace hiqdev\rdap\core\ValueObject\DomainVariant;

final class Variant
{
    /**
     * @var Relation[]
     */
    private $relations;

    /**
     * @var string
     */
    private $idnTable;

    /**
     * @var Name[]
     */
    private $variantNames;

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
