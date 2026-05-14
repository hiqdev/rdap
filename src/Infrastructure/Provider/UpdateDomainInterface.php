<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Provider;

interface UpdateDomainInterface
{
    /** @param string $domainName Fully-qualified domain name whose RDAP-saved status should be stamped */
    public function setSuccessUpdateStatus(string $domainName): void;
}
