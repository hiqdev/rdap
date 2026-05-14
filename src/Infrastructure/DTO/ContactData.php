<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\DTO;

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

    public function getId(): string { return $this->id; }
    public function getRole(): string { return $this->role; }
    public function isWhoisProtected(): bool { return $this->whoisProtected; }
    public function getCompany(): string { return $this->company; }
    public function getFullName(): string { return $this->fullName; }
    public function getEmail(): string { return $this->email; }
    public function getStreet(): string { return $this->street; }
    public function getCity(): string { return $this->city; }
    public function getProvince(): string { return $this->province; }
    public function getPostalCode(): string { return $this->postalCode; }
    public function getCountry(): string { return $this->country; }
    public function getPhone(): string { return $this->phone; }
}
