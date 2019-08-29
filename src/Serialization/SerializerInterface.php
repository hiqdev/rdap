<?php declare(strict_types=1);

namespace hiqdev\rdap\core\Serialization;

/**
 * Interface SerializerInterface
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
interface SerializerInterface
{
    public const FORMAT_JSON = 'json';

    public function serialize(object $entity, string $targetFormat = self::FORMAT_JSON);

    /**
     * @param string|array $input
     * @param string $sourceFormat
     * @return array|string
     */
    public function deserialize($input, string $sourceFormat = self::FORMAT_JSON);
}
