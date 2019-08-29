<?php declare(strict_types=1);

namespace hiqdev\rdap\core\Json\Transformer;

use hiqdev\rdap\core\Entity\Domain;
use hiqdev\rdap\core\ValueObject\DomainVariant\Variant;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\NullResource;
use League\Fractal\TransformerAbstract;

final class VariantTransformer extends TransformerAbstract
{
    /**
     * @var NameTransformer
     */
    private $nameTransformer;

    public function __construct(NameTransformer $nameTransformer)
    {
        $this->nameTransformer = $nameTransformer;
    }

    protected $availableIncludes = [
        'variantNames'
    ];

    public function transform(Variant $variant): array
    {
        return [
            'idnTable' => $variant->getIdnTable(),
        ];
    }

    public function includeVariantNames(Variant $variant): Collection
    {
        return $this->collection($variant->getVariantNames(), $this->nameTransformer);
    }
}
