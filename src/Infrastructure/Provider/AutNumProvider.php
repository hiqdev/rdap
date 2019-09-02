<?php

namespace hiqdev\rdap\core\Infrastructure\Provider;

use hiqdev\rdap\core\Domain\Entity\AutNum;
use hiqdev\rdap\core\Infrastructure\Exception\ObjectNotAvailableException;

interface AutNumProvider
{
    /**
     * @param int $number the autonomus network number
     * @throws ObjectNotAvailableException if the requested AutNum was not found
     */
    public function get(int $number): AutNum;
}
