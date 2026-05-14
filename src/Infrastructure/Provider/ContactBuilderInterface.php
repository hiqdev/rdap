<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Provider;

use hiqdev\rdap\core\Domain\Entity\Entity;
use hiqdev\rdap\core\Infrastructure\DTO\ContactDataInterface;

/** Builds RDAP Entity objects with vCards from a list of contact DTOs. */
interface ContactBuilderInterface
{
    /**
     * @param ContactDataInterface[] $contacts
     * @return Entity[]
     */
    public function build(array $contacts): array;
}
