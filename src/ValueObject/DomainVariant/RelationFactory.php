<?php

namespace hiqdev\rdap\core\ValueObject\DomainVariant;


use hiqdev\rdap\core\Constant\Relation;

class RelationFactory
{
    /**
     * RelationFactory constructor.
     */
    private function __construct()
    {
    }

    /**
     * @param string $relation
     * @return Relation
     */
    public static function Of(string $relation): object
    {
        try {
            return Relation::$relation();
        } catch (\InvalidArgumentException $e) {
            return Relation::BASIC();
        }
    }
}
