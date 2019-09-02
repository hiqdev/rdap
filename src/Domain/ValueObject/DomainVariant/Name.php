<?php
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Domain\ValueObject\DomainVariant;

use hiqdev\rdap\core\Domain\ValueObject\DomainName;

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
