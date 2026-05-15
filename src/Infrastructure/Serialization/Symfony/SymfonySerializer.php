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

/**
 * Symfony Serializer adapter implementing SerializerInterface.
 *
 * Pre-configures the serializer with all normalizers needed for RDAP output:
 * EnumNormalizer, VcardNormalizer, AsStringNormalizer, DomainNormalizer,
 * DateTimeNormalizer (ISO 8601 UTC), and ObjectNormalizer with null-skipping.
 */
final class SymfonySerializer implements SerializerInterface
{
    /**
     * @var Serializer
     */
    private $serializer;

    /** Builds the Symfony Serializer with all normalizers and the JSON encoder pre-configured */
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

    /**
     * @param object $entity        RDAP entity to serialise
     * @param string $targetFormat  Target format; use {@see SerializerInterface::FORMAT_JSON}
     * @param array  $targetOptions Additional Symfony Serializer context options
     * @return string Serialised representation (JSON by default)
     */
    public function serialize(
        object $entity,
        string $targetFormat = self::FORMAT_JSON,
        array $targetOptions = []
    ): string {
        return $this->serializer->serialize($entity, $targetFormat, $targetOptions);
    }

    /**
     * @param array|object $input        Data to deserialise (JSON string when using FORMAT_JSON)
     * @param string|null  $type         Target class (required)
     * @param string       $sourceFormat Source format
     * @return mixed Deserialised object of the requested type
     * @throws InvalidArgumentException When $type is null
     */
    public function deserialize(
        $input,
        ?string $type = null,
        string $sourceFormat = self::FORMAT_JSON
    ): mixed {
        if ($type === null) {
            throw new InvalidArgumentException('Type must be provided for deserialization.');
        }
        return $this->serializer->deserialize($input, $type, $sourceFormat);
    }
}
