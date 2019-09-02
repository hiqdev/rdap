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
 * Class KeyData object, that can be one of the following members:
 *  +   flags -- an integer representing the flags field value in
 *  the DNSKEY record [RFC4034] in presentation format
 *  +   protocol -- an integer representation of the protocol field
 *  value of the DNSKEY record [RFC4034] in presentation format
 *  +   publicKey -- a string representation of the public key in
 *  the DNSKEY record [RFC4034] in presentation format
 *  +   algorithm -- an integer as specified by the algorithm field
 *  of a DNSKEY record as specified by [RFC4034] in presentation
 *  format
 *  +   events
 *  +   links.
 */
class KeyData extends AbstractData
{
    /**
     * @var string
     */
    private $flags;

    /**
     * @var string
     */
    private $protocol;

    /**
     * @var string
     */
    private $publicKey;

    /**
     * KeyData constructor.
     * @param Event[] $events
     * @param Link[] $links
     * @param int $algorythm
     * @param string $flags
     * @param string $protocol
     * @param string $publicKey
     */
    public function __construct(
        array $events,
        array $links,
        int $algorythm,
        string $flags,
        string $protocol,
        string $publicKey
    ) {
        parent::__construct($events, $links, $algorythm);

        $this->flags = $flags;
        $this->publicKey = $publicKey;
        $this->protocol = $protocol;
    }

    /**
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * @return string
     */
    public function getFlags(): string
    {
        return $this->flags;
    }

    /**
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }
}
