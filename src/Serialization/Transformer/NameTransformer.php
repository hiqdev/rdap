<?php


namespace hiqdev\rdap\core\Json\Transformer;

use hiqdev\rdap\core\ValueObject\DomainVariant\Name;
use League\Fractal\TransformerAbstract;

final class NameTransformer extends TransformerAbstract
{
    /**
     * @var DomainNameTransformer
     */
    private $domainNameTransformer;

    public function __construct(DomainNameTransformer $domainNameTransformer)
    {
        $this->domainNameTransformer = $domainNameTransformer;
    }

    public function transform(Name $name): array
    {
        return [
            'ldhName' => $this->item($name->getLdhName(), $this->domainNameTransformer),
            'unicodeName' => $this->item($name->getUnicodeName(), $this->domainNameTransformer),
        ];
    }
}
