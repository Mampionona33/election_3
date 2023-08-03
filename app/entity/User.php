<?php

namespace Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "User")]
class User
{
    #[Id]
    #[Column(name: 'id_user', type: 'integer')]
    #[GeneratedValue(strategy: 'AUTO')]
    private int $id;
    #[Column(name: 'email', length: 100, unique: true)]
    private $email;
    #[Column(name: 'password', length: 250)]
    private $password;
    #[Column(name: 'id_groupe', type: 'integer')]
    private $id_groupe;

    /**
     * Getter
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getGroupeId(): int
    {
        return $this->id_groupe;
    }

    /**
     * setter
     */

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }


    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setGroupeId(int $id_groupe): void
    {
        $this->id_groupe = $id_groupe;
    }


    public function __construct()
    {
    }
}
