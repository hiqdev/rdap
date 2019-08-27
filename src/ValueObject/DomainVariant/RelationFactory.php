<?php

namespace hiqdev\rdap\core\ValueObject\DomainVariant;


use hiqdev\rdap\core\Constant\Relations\DefaultRelation;

class RelationFactory
{
    public function Of(string $relation): BasicRelation
    {
        try {
            return DefaultRelation::$relation();
        } catch (\InvalidArgumentException $e) {
            return new BasicRelation($relation);
        }
    }
}
