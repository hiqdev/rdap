<?php

declare(strict_types=1);
/**
 * Registration Data Access Protocol – core objects implemantation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Serialization\Symfony;

use Doctrine\Common\Annotations\AnnotationReader;
use hiqdev\rdap\core\Serialization\SerializerInterface;
use hiqdev\rdap\core\Serialization\Symfony\Normalizer\AsStringNormalizer;
use hiqdev\rdap\core\Serialization\Symfony\Normalizer\EnumNormalizer;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
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
        $classMetaDataFactory = new ClassMetadataFactory(
            new AnnotationLoader(
                new AnnotationReader()
            )
        );
        $objectNormalizer = new ObjectNormalizer(
            $classMetaDataFactory,
            null,
            null,
            new PhpDocExtractor(),
            null,
            null,
            [
                ObjectNormalizer::SKIP_NULL_VALUES => true,
                ObjectNormalizer::IGNORED_ATTRIBUTES => [
                    'rdapConformance',
                ],
            ]
        );
        $serializer = new Serializer([
            new ArrayDenormalizer(),

            new DateTimeNormalizer(),
            new EnumNormalizer(),
            new AsStringNormalizer(),

            $objectNormalizer,
        ], [
            new JsonEncoder(),
        ]);

        $this->serializer = $serializer;
    }

    public function serialize(object $entity, string $targetFormat = self::FORMAT_JSON)
    {
        return $this->serializer->serialize($entity, $targetFormat);
    }

    public function deserialize($input, ?string $type = null, string $sourceFormat = self::FORMAT_JSON)
    {
        if ($type === null && is_object($input)) {
            $type = get_class($input);
        }
        if ($type === null) {
            throw new \InvalidArgumentException('Type is was neither passed nor guessed.');
        }

        return $this->serializer->deserialize($input, $type, $sourceFormat);
    }
}
