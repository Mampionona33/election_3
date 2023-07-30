<?php

namespace Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class User
{
    #[Id]
    #[Column(name: 'id_user', type: 'integer')]
    #[GeneratedValue(strategy: 'AUTO')]
    private int|null $id;
    #[Column(name: 'email', length: 100)]
    private $email;
    #[Column(name: 'password', length: 250)]
    private $password;
    #[Column(name: 'id_groupe', type: 'integer')]
    private $id_groupe;

    /**
     * Getter
     */

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setGroupeId(int $id_groupe): void
    {
        $this->id_groupe = $id_groupe;
    }

    public function getGroupeId(): int
    {
        return $this->id_groupe;
    }

    public function __construct()
    {
    }
}
