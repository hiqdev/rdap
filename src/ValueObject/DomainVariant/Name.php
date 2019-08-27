<?php

namespace hiqdev\rdap\core\ValueObject\DomainVariant;

use hiqdev\rdap\core\ValueObject\DomainName;

final class Name
{
    /**
     * @var DomainName
     */
    private $ldhName;

    /**
     * @var DomainName
     */
    private $unicodeName;

    /**
     * Name constructor.
     * @param DomainName $ldhName
     * @param DomainName $unicodeName
     */
    public function __construct(DomainName $ldhName, DomainName $unicodeName)
    {
        $this->ldhName = $ldhName;
        $this->unicodeName = $unicodeName;
    }

    /**
     * @return DomainName
     */
    public function getLdhName(): DomainName
    {
        return $this->ldhName;
    }

    /**
     * @return DomainName
     */
    public function getUnicodeName(): DomainName
    {
        return $this->unicodeName;
    }
}
