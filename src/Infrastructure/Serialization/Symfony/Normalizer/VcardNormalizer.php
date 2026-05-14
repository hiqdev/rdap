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

use hiqdev\rdap\core\Domain\Entity\VCard;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class EnumNormalizer.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class VcardNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    /** @return bool Always true — normalisation support result is stable across calls */
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    /** {@inheritdoc} */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof VCard;
    }

    /** {@inheritdoc} */
    public function normalize($object, $format = null, array $context = [])
    {
        return $object->jsonSerialize();
    }
}
