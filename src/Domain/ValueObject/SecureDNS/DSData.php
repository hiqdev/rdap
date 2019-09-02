<?php
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Domain\ValueObject\SecureDNS;

use hiqdev\rdap\core\Domain\ValueObject\Event;
use hiqdev\rdap\core\Domain\ValueObject\Link;

/**
 * Class DSData -- that can be one of the following members:
 *  +  keyTag -- an integer as specified by the key tag field of a
 *  DNS DS record as specified by [RFC4034] in presentation
 *  format
 *  +  algorithm -- an integer as specified by the algorithm field
 *  of a DNS DS record as described by RFC 4034 in presentation
 *  format
 *  +  digest -- a string as specified by the digest field of a DNS
 *  DS record as specified by RFC 4034 in presentation format
 *  +  digestType -- an integer as specified by the digest type
 *  field of a DNS DS record as specified by RFC 4034 in
 *  presentation format
 *  +  events -- see Section 4.5
 *  +  links -- see Section 4.2.
 */
class DSData extends AbstractData
{
    /**
     * @var int
     */
    private $keyTag;

    /**
     * @var string
     */
    private $digest;

    /**
     * @var int
     */
    private $digestType;

    /**
     * DSData constructor.
     * @param Event[] $events
     * @param Link[] $links
     * @param int $algorythm
     * @param int $keyTag
     * @param string $digest
     * @param int $digestType
     */
    public function __construct(
        array $events,
        array $links,
        int $algorythm,
        int $keyTag,
        string $digest,
        int $digestType
    ) {
        parent::__construct($events, $links, $algorythm);
        $this->keyTag = $keyTag;
        $this->digest = $digest;
        $this->digestType = $digestType;
    }

    /**
     * @return string
     */
    public function getDigest(): string
    {
        return $this->digest;
    }

    /**
     * @return int
     */
    public function getDigestType(): int
    {
        return $this->digestType;
    }

    /**
     * @return int
     */
    public function getKeyTag(): int
    {
        return $this->keyTag;
    }
}
