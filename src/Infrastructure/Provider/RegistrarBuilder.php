<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\Provider;

use hiqdev\rdap\core\Domain\Constant\Role;
use hiqdev\rdap\core\Domain\Entity\Entity;
use hiqdev\rdap\core\Domain\Entity\VCard;
use hiqdev\rdap\core\Domain\ValueObject\Link;
use hiqdev\rdap\core\Domain\ValueObject\PublicId;

/**
 * Builds the registrar Entity from REGISTRAR_* environment variables.
 *
 * Produces a registrar entity with a vCard, IANA ID public identifier,
 * an about link, and a nested abuse entity — as required by the
 * ICANN RDAP Response Profile.
 */
final class RegistrarBuilder implements RegistrarBuilderInterface
{
    /** @return Entity Registrar entity with vCard, IANA ID, abuse sub-entity, and self link */
    public function build(): Entity
    {
        $ianaId = getenv('REGISTRAR_IANAID') ?: '';
        $vcard  = (new VCard())
            ->setFullName(getenv('REGISTRAR_ORG') ?: '')
            ->setCompany(getenv('REGISTRAR_ORG') ?: '')
            ->setEmail(getenv('REGISTRAR_EMAIL') ?: '')
            ->setTel(getenv('REGISTRAR_PHONE') ?: '')
            ->setAddress(
                getenv('REGISTRAR_STREET') ?: '',
                getenv('REGISTRAR_CITY') ?: '',
                getenv('REGISTRAR_ZIP') ?: '',
                getenv('REGISTRAR_COUNTRY') ?: '',
                getenv('REGISTRAR_PROVINCE') ?: ''
            )
            ->setUrl(getenv('REGISTRAR_URL') ?: '');

        $entity = new Entity();
        $entity->addVcard($vcard);
        $entity->setHandle($ianaId);
        $entity->addPublicId(new PublicId('IANA Registrar ID', $ianaId));

        $link = new Link(getenv('REGISTRAR_URL') ?: '');
        $link->setValue(getenv('RDAP_SITE') ?: '');
        $link->setRel('about');
        $entity->addLink($link);
        $entity->addRole(Role::REGISTRAR);

        $abuseEntity = new Entity();
        $abuseEntity->addVcard($vcard);
        $abuseEntity->setHandle('ABUSE-' . $ianaId);
        $abuseEntity->addRole(Role::ABUSE);
        $entity->addEntity($abuseEntity);

        return $entity;
    }
}
