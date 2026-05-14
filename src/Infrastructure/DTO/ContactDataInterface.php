<?php

declare(strict_types=1);

namespace hiqdev\rdap\core\Infrastructure\DTO;

interface ContactDataInterface
{
    public function getId(): string;
    public function getRole(): string;
    public function isWhoisProtected(): bool;
    public function getCompany(): string;
    public function getFullName(): string;
    public function getEmail(): string;
    public function getStreet(): string;
    public function getCity(): string;
    public function getProvince(): string;
    public function getPostalCode(): string;
    public function getCountry(): string;
    public function getPhone(): string;
}
