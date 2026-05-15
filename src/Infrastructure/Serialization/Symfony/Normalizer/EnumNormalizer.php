<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Serialization\Symfony\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Normalizes PHP backed enums to their scalar value string.
 *
 * Used so that Status, Role, EventAction, etc. are serialised as their
 * string backing value rather than as objects.
 */
final class EnumNormalizer implements NormalizerInterface
{
    /** @return array<class-string, bool> All backed enums are supported */
    public function getSupportedTypes(?string $format): array
    {
        return [\BackedEnum::class => true];
    }

    /** @return bool True when $data is a backed enum instance */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof \BackedEnum;
    }

    /** @return string|int The scalar backing value of the enum case */
    public function normalize(mixed $object, ?string $format = null, array $context = []): string|int
    {
        return $object->value;
    }
}
