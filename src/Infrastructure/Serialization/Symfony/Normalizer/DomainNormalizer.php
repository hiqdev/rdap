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

namespace hiqdev\rdap\core\Infrastructure\Serialization\Symfony\Normalizer;

use hiqdev\rdap\core\Domain\Entity\Domain;
use hiqdev\rdap\core\Domain\ValueObject\DomainName;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class EnumNormalizer.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class DomainNormalizer implements DenormalizerInterface, CacheableSupportsMethodInterface
{
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedArrayAccess
     * @psalm-suppress MixedArgument
     */
    public function denormalize($data, $type, $format = null, array $context = [])
    {
        $data['ldhName'] = DomainName::of($data['ldhName']);

        return $data;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === Domain::class;
    }
}
