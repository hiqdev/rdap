<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Provider;

use hiqdev\rdap\core\Domain\Constant\Role;
use hiqdev\rdap\core\Domain\Entity\Entity;
use hiqdev\rdap\core\Domain\Entity\VCard;
use hiqdev\rdap\core\Infrastructure\DTO\ContactDataInterface;

/**
 * Builds RDAP Entity objects with jCard vCards from contact DTOs.
 *
 * Groups contacts by ID so that a single entity carries all roles for one contact.
 * Personal fields (name, address, phone) are omitted when whoisProtected is true.
 */
final class ContactBuilder implements ContactBuilderInterface
{
    /**
     * @param ContactDataInterface[] $contacts
     * @return Entity[]
     */
    public function build(array $contacts): array
    {
        $rolesByContact = [];
        $vcardByContact = [];

        foreach ($contacts as $contact) {
            $id = $contact->getId();
            $rolesByContact[$id][] = Role::fromName(strtoupper($contact->getRole()));
            $vcardByContact[$id]   = $this->buildVCard($contact);
        }

        $entities = [];
        foreach ($vcardByContact as $id => $vcard) {
            $entity = new Entity();
            foreach ($rolesByContact[$id] as $role) {
                $entity->addRole($role);
            }
            $entity->addVcard($vcard);
            $entities[] = $entity;
        }

        return $entities;
    }

    private function buildVCard(ContactDataInterface $contact): VCard
    {
        $wp    = $contact->isWhoisProtected();
        $vcard = (new VCard())
            ->setCompany($wp ? '' : $contact->getCompany())
            ->setFullName($wp ? '' : $contact->getFullName())
            ->setEmail($contact->getEmail())
            ->setAddress(
                $wp ? '' : $contact->getStreet(),
                $wp ? '' : $contact->getCity(),
                $wp ? '' : $contact->getPostalCode(),
                $contact->getCountry(),
                $contact->getProvince()
            );

        if (!$wp) {
            $vcard->setTel($contact->getPhone());
        }

        return $vcard;
    }
}
