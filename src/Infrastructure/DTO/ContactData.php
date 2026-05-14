<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\DTO;

/**
 * Immutable DTO carrying raw contact data fetched from the registry DB.
 *
 * Personal fields (name, address, phone) may be empty strings when the contact
 * is under WHOIS privacy protection; callers should check isWhoisProtected()
 * before rendering them in the RDAP output.
 */
final class ContactData implements ContactDataInterface
{
    /** @var string */
    private $id;

    /** @var string registrant|technical|administrative */
    private $role;

    /** @var bool */
    private $whoisProtected;

    /** @var string */
    private $company;

    /** @var string */
    private $fullName;

    /** @var string */
    private $email;

    /** @var string */
    private $street;

    /** @var string */
    private $city;

    /** @var string */
    private $province;

    /** @var string */
    private $postalCode;

    /** @var string two-letter country code */
    private $country;

    /** @var string */
    private $phone;

    /**
     * @param string $id            Registry contact identifier
     * @param string $role          RDAP role: registrant, technical, or administrative
     * @param bool   $whoisProtected Whether WHOIS privacy is active for this contact
     * @param string $company       Organisation / company name
     * @param string $fullName      Contact full name
     * @param string $email         Email address
     * @param string $street        Street address line
     * @param string $city          City name
     * @param string $province      State or province
     * @param string $postalCode    Postal / ZIP code
     * @param string $country       Two-letter ISO 3166-1 alpha-2 country code
     * @param string $phone         Voice telephone number
     */
    public function __construct(
        string $id,
        string $role,
        bool $whoisProtected,
        string $company,
        string $fullName,
        string $email,
        string $street,
        string $city,
        string $province,
        string $postalCode,
        string $country,
        string $phone
    ) {
        $this->id             = $id;
        $this->role           = $role;
        $this->whoisProtected = $whoisProtected;
        $this->company        = $company;
        $this->fullName       = $fullName;
        $this->email          = $email;
        $this->street         = $street;
        $this->city           = $city;
        $this->province       = $province;
        $this->postalCode     = $postalCode;
        $this->country        = $country;
        $this->phone          = $phone;
    }

    /** @return string Registry contact identifier */
    public function getId(): string { return $this->id; }
    /** @return string RDAP role: registrant, technical, or administrative */
    public function getRole(): string { return $this->role; }
    /** @return bool True when WHOIS privacy protection is active */
    public function isWhoisProtected(): bool { return $this->whoisProtected; }
    /** @return string Organisation / company name */
    public function getCompany(): string { return $this->company; }
    /** @return string Contact full name */
    public function getFullName(): string { return $this->fullName; }
    /** @return string Email address */
    public function getEmail(): string { return $this->email; }
    /** @return string Street address line */
    public function getStreet(): string { return $this->street; }
    /** @return string City name */
    public function getCity(): string { return $this->city; }
    /** @return string State or province */
    public function getProvince(): string { return $this->province; }
    /** @return string Postal / ZIP code */
    public function getPostalCode(): string { return $this->postalCode; }
    /** @return string Two-letter ISO 3166-1 alpha-2 country code */
    public function getCountry(): string { return $this->country; }
    /** @return string Voice telephone number */
    public function getPhone(): string { return $this->phone; }
}
