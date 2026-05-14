<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\DTO;

/** Read contract for a contact DTO (id, role, WHOIS protection flag, and postal/contact fields). */
interface ContactDataInterface
{
    /** @return string Registry contact identifier */
    public function getId(): string;

    /** @return string RDAP role string: registrant, technical, or administrative */
    public function getRole(): string;

    /** @return bool True when the contact is under WHOIS privacy protection */
    public function isWhoisProtected(): bool;

    /** @return string Organisation / company name */
    public function getCompany(): string;

    /** @return string Contact full name */
    public function getFullName(): string;

    /** @return string Contact email address */
    public function getEmail(): string;

    /** @return string Street address line */
    public function getStreet(): string;

    /** @return string City name */
    public function getCity(): string;

    /** @return string State or province */
    public function getProvince(): string;

    /** @return string Postal / ZIP code */
    public function getPostalCode(): string;

    /** @return string Two-letter ISO 3166-1 alpha-2 country code */
    public function getCountry(): string;

    /** @return string Voice telephone number */
    public function getPhone(): string;
}
