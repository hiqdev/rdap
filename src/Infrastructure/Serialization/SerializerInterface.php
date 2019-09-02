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

namespace hiqdev\rdap\core\Infrastructure\Serialization;

/**
 * Interface SerializerInterface.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
interface SerializerInterface
{
    public const FORMAT_JSON = 'json';

    /**
     * @param object $entity
     * @param string $targetFormat
     * @return mixed depending on $targetFormat
     */
    public function serialize(object $entity, string $targetFormat = self::FORMAT_JSON);

    /**
     * @param array|object $input
     * @param string|null $type
     * @param string $sourceFormat
     * @return array|object
     */
    public function deserialize($input, ?string $type = null, string $sourceFormat = self::FORMAT_JSON);
}
