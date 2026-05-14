<?php

declare(strict_types=1);
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Infrastructure\Serialization\Symfony;

use Exception;
use hiqdev\rdap\core\Infrastructure\Serialization\SerializerInterface;
use hiqdev\rdap\core\Infrastructure\Serialization\Symfony\Normalizer\AsStringNormalizer;
use hiqdev\rdap\core\Infrastructure\Serialization\Symfony\Normalizer\DomainNormalizer;
use hiqdev\rdap\core\Infrastructure\Serialization\Symfony\Normalizer\EnumNormalizer;
use hiqdev\rdap\core\Infrastructure\Serialization\Symfony\Normalizer\VcardNormalizer;
use InvalidArgumentException;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class SymfonySerializer implements SerializerInterface
{
    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct()
    {
        $classMetaDataFactory = new ClassMetadataFactory(new AttributeLoader());
        $objectNormalizer = new ObjectNormalizer(
            $classMetaDataFactory,
            null,
            null,
            new PhpDocExtractor(),
            null,
            null,
            [
                ObjectNormalizer::SKIP_NULL_VALUES => true,
                ObjectNormalizer::IGNORED_ATTRIBUTES => ['vcard'],
            ]
        );
        $serializer = new Serializer([
            new ArrayDenormalizer(),

            new DomainNormalizer(),
            new DateTimeNormalizer([
                DateTimeNormalizer::FORMAT_KEY => 'Y-m-d\TH:i:s\Z',
                DateTimeNormalizer::TIMEZONE_KEY => new \DateTimeZone('UTC'),
            ]),
            new EnumNormalizer(),
            new VcardNormalizer(),
            new AsStringNormalizer(),

            $objectNormalizer,
        ], [
            new JsonEncoder(),
        ]);

        $this->serializer = $serializer;
    }

    public function serialize(
        object $entity,
        string $targetFormat = self::FORMAT_JSON,
        array $targetOptions = []
    ): string {
        return $this->serializer->serialize($entity, $targetFormat, $targetOptions);
    }

    public function deserialize(
        $input,
        ?string $type = null,
        string $sourceFormat = self::FORMAT_JSON
    ) {
        throw new Exception('Deserialization is not implemented yet');
        if ($type === null && is_object($input)) {
            $type = get_class($input);
        }
        if ($type === null) {
            throw new InvalidArgumentException('Type is was neither passed nor guessed.');
        }

        return $this->serializer->deserialize($input, $type, $sourceFormat);
    }
}
