<?php declare(strict_types=1);

namespace hiqdev\rdap\core\Serialization\Symfony\Normalizer;

use hiqdev\rdap\core\ValueObject\Label\Label;
use MabeEnum\Enum;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use function get_class;

/**
 * Class AsStringNormalizer
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class AsStringNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    /** {@inheritDoc} */
    public function supportsNormalization($data, $format = null)
    {
        return is_object($data) && method_exists($data, '__toString');
    }

    /** {@inheritDoc} */
    public function normalize($object, $format = null, array $context = [])
    {
        return (string)$object;
    }
}
