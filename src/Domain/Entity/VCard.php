<?php

namespace hiqdev\rdap\core\Domain\Entity;

/**
 * jCard/vCard 4.0 builder for RDAP entity contact information (RFC 7095).
 *
 * Builds an ordered array of vCard property tuples [name, params, type, value]
 * suitable for serialisation as the vcardArray member of an RDAP entity.
 */
final class VCard implements \JsonSerializable
{
    const VERSION = '4.0';

    /** @var array */
    private $availableProperties = [
        'version' => 'text',
        'fn' => 'text',
        'n' => 'text',
        'tel' => 'text',
        'email' => 'text',
        'org' => 'text',
        'adr' => 'text',
        'url'  => 'uri',
    ];

    /** @var array  */
    private $vCard;

    /**
     * @param array $vCard Optional initial vCard property array to merge into the default set
     */
    public function __construct(array $vCard = [])
    {
        $this->setVersion(self::VERSION);
        $this->vCard = array_merge($this->vCard, $vCard);
    }

    /** @return array Ordered list of jCard property arrays (RFC 7095 format) */
    public function jsonSerialize(): mixed
    {
        return array_values($this->vCard);
    }

    /** @return self Sets the vCard version property */
    public function setVersion(string $version): VCard
    {
        return $this->setProperty('version', $version);
    }

    /** @return self Sets the formatted name (fn) property */
    public function setFullName(string $name, array $properties = []): VCard
    {
        return $this->setProperty('fn', $name, $properties);
    }

    /** @return self Sets the structured name (n) property */
    public function setName(string $name, array $properties = []): VCard
    {
        return $this->setProperty('n', $name, $properties);
    }

    /** @return self Sets the email property */
    public function setEmail(string $email, array $properties = []): VCard
    {
        return $this->setProperty('email', $email, $properties);
    }

    /** @return self Sets the org property; no-op when $org is empty */
    public function setOrg(?string $org = null, array $properties = []): VCard
    {
        if (empty($org)) {
            return $this;
        }

        return $this->setProperty('org', $org, $properties);
    }

    /** @return self Alias for setOrg() */
    public function setCompany(?string $company = null, array $properties = []): VCard
    {
        return $this->setOrg($company, $properties);
    }

    /** @return self Sets the url property */
    public function setUrl(string $url, array $properties = []): VCard
    {
        return $this->setProperty('url', $url, $properties);
    }

    /** @return self Sets the tel property; defaults type to "voice" when not specified */
    public function setTel(string $tel, array $properties = []): VCard
    {
        if (empty($properties) || empty($properties['type'])) {
            $properties['type'] = 'voice';
        }

        return $this->setProperty('tel', $tel, $properties);
    }

    /**
     * @param string      $street     Street address line
     * @param string      $city       City name
     * @param string      $zip        Postal / ZIP code
     * @param string|null $country    Two-letter country code
     * @param string|null $state      State or province
     * @param string      $ext        Extended address (apartment, suite, etc.)
     * @param string      $name       Delivery address name
     * @param array       $properties Additional vCard property parameters
     * @return self
     */
    public function setAddress(
        string $street,
        string $city,
        string $zip,
        ?string $country = null,
        ?string $state = '',
        string $ext = '',
        string $name = '',
        array $properties = []
    ): VCard {
        $properties['cc'] = strtoupper($properties['cc'] ?? $country);

        $this->vCard['adr'] = [
            'adr',
            $properties,
            $this->availableProperties['adr'],
            [
                $name,
                $ext,
                $street,
                $city,
                $state,
                $zip,
                '',
            ],
        ];
        return $this;
    }

    /**
     * @return array
     */
    public function getVCard(): array
    {
        return $this->vCard;
    }

    /**
     * @param string $property   vCard property name (fn, email, org, …)
     * @param string $value      Property value
     * @param array  $properties Additional vCard parameters (type, cc, …)
     * @param string $type       vCard value type (text, uri, …)
     * @return self
     */
    protected function setProperty(string $property, string $value, array $properties = [], string $type = 'text'): VCard
    {
        $this->vCard[$property] = [
            $property,
            empty($properties) ? new \stdClass() : $properties,
            $this->availableProperties[$property] ?? $type,
            $value
        ];
        return $this;
    }
}
