<?php declare(strict_types=1);

namespace hiqdev\rdap\core\Serialization\Symfony\Normalizer;

use MabeEnum\Enum;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use function get_class;

/**
 * Class EnumNormalizer
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class EnumNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    /** {@inheritDoc} */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Enum;
    }

    /** {@inheritDoc} */
    public function normalize($object, $format = null, array $context = [])
    {
        /** @var Enum $object */
        return $object->getValue();
    }
}
