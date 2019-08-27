<?php

namespace hiqdev\rdap\core\Entity;

use hiqdev\rdap\core\Constant\ObjectClassName;
use hiqdev\rdap\core\Constant\Role;
use hiqdev\rdap\core\ValueObject\DomainName;
use hiqdev\rdap\core\ValueObject\Event;
use hiqdev\rdap\core\ValueObject\PublicId;

final class Entity extends Common
{
    public const OBJECT_CLASS_NAME = 'entity';

    /**
     * @var string|null
     *
     * DNRs and RIRs have registry-unique identifiers that
     * may be used to specifically reference an object
     * instance.  The semantics of this data type as found
     * in this document are to be a registry-unique
     * reference to the closest enclosing object where the
     * value is found.  The data type names "registryId",
     * "roid", "nic-handle", "registrationNo", etc., are
     * terms often synonymous with this data type.  In
     * this document, the term "handle" is used.  The term
     * exposed to users by clients is a presentation issue
     * beyond the scope of this document.
     */
    private $handle;

    /**
     * @var Contact|null a jCard with the entity's contact information
     */
    private $vcardArray;

    /**
     * @var Role[]|null an array, each role signifying the relationship an
     * object would have with its closest containing object (see
     */
    private $roles;

    /**
     * @var Event[]|null this data structure takes the same form as the
     * events data structure (see Section 4.5), but each object in the
     * array MUST NOT have an "eventActor" member.  These objects denote
     * that the entity is an event actor for the given events.  See
     * Appendix B regarding the various ways events can be modeled.
     */
    private $asEventActor;

    /**
     * @var PublicId[]|null
     */
    private $publicIds;

    /**
     * @var Entity[] an array of entity objects as defined by this section
     */
    private $entities;

    public function __construct(
    ) {
        parent::__construct(ObjectClassName::ENTITY());
    }

    /**
     * @return string|null
     */
    public function getHandle(): ?string
    {
        return $this->handle;
    }


}
