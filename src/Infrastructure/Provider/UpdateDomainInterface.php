<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Provider;

/** Contract for stamping a domain with the rdapSaved status after a successful RDAP pack. */
interface UpdateDomainInterface
{
    /** @param string $domainName Fully-qualified domain name whose RDAP-saved status should be stamped */
    public function setSuccessUpdateStatus(string $domainName): void;
}
