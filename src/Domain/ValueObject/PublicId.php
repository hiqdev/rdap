<?php
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\rdap\core\Domain\ValueObject;

/**
 * Class PublicId.
 *
 * This data structure maps a public identifier to an object class.  It
 * is named "publicIds" and is an array of objects, with each object
 * containing the following members:
 *
 * o  type -- a string denoting the type of public identifier
 * o  identifier -- a public identifier of the type denoted by "type"
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class PublicId
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $identifier;

    public function __construct(string $type, string $identifier)
    {
        $this->type = $type;
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
