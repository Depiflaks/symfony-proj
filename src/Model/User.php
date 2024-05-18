<?php
declare(strict_types=1);

namespace App\Model;

#require_once __DIR__ . '/UserInterface.php';

class User implements UserInterface
{
    public function __construct(
        private ?int $user_id, 
        private string $first_name, 
        private string $last_name, 
        private ?string $middle_name, 
        private string $gender, 
        private ?string $birth_date, 
        private string $email, 
        private ?string $phone, 
        private ?string $avatar_path)
    {

    }

    public function getId(): ?int
    {
        return $this->user_id;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getMiddleName(): ?string
    {
        return $this->middle_name;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getBirthDate(): ?string
    {
        return $this->birth_date;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getAvatarPath(): ?string
    {
        return $this->avatar_path;
    }
}