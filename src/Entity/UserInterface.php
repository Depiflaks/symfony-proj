<?php
declare(strict_types=1);

namespace App\Entity;

interface UserInterface
{
    public function getId(): ?int;
    public function getFirstName(): string;
    public function getLastName(): string;
    public function getMiddleName(): ?string;
    public function getGender(): string;
    public function getBirthDate(): ?string;
    public function getEmail(): string;
    public function getPhone(): ?string;
    public function getAvatarPath(): ?string;
}