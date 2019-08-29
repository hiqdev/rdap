<?php declare(strict_types=1);

namespace hiqdev\rdap\core\Json\Transformer;

use hiqdev\rdap\core\Entity\Domain;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\NullResource;
use League\Fractal\TransformerAbstract;

final class DomainTransformer extends TransformerAbstract
{
    public function __construct()
    {
    }

    protected $availableIncludes = [
        'variants',
        
        'links',
        'notices',
        'remarks',
        'lang',
        'events',
        'status',
        'port43',
        'nameServers',
        'secureDNS',
        'entities',
        'publicIds',
        'network',
    ];

    public function transform(Domain $domain): array
    {
        return [
            'objectClassName' => $domain->getObjectClassName(),
            'handle' => $domain->getHandle(),
            'ldhName' => (string)$domain->getLdhName(),
            'unicodeName' => (string)$domain->getLdhName()->toUnicode(),
            
        ];
    }

    /**
     * @param Domain $domain
     * @return Collection|NullResource
     */
    public function includeVariants(Domain $domain)
    {
        if ($domain->getVariants() === null) {
            return new NullResource();
        }

        return $this->collection($domain->getVariants(), );
    }
}
