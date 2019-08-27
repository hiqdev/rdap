<?php

namespace hiqdev\rdap\core\ValueObject\DomainVariant;


use hiqdev\rdap\core\Constant\Relations\DefaultRelation;

class RelationFactory
{
    /**
     * @param string $relation
     * @return DefaultRelation|BasicRelation
     */
    public function Of(string $relation): object
    {
        try {
            return DefaultRelation::$relation();
        } catch (\InvalidArgumentException $e) {
            return new BasicRelation($relation);
        }
    }
}
