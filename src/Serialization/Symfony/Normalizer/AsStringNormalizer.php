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

namespace hiqdev\rdap\core\Serialization\Symfony\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class AsStringNormalizer.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class AsStringNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    /** {@inheritdoc} */
    public function supportsNormalization($data, $format = null)
    {
        return is_object($data) && method_exists($data, '__toString');
    }

    /** {@inheritdoc} */
    public function normalize($object, $format = null, array $context = [])
    {
        return (string) $object;
    }
}
