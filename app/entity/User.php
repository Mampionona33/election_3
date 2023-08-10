<?php

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

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

    #[ManyToOne(targetEntity: Groupe::class, inversedBy: 'users')]
    #[JoinColumn(name: 'id_groupe', referencedColumnName: 'id_groupe')]
    private Groupe $groupe;

    public function __construct()
    {
        $this->groupe = new ArrayCollection();
    }

    /**
     * Getter
     */
    public function getId(): int
    {
        return $this->id;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getGroupe(): Groupe
    {
        return $this->groupe;
    }

    /**
     * setter
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setGroupe(): void
    {
    }
}
