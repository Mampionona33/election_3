<?php

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\ORM\PersistentCollection as ORMPersistentCollection;
use Doctrine\ORM\Mapping\InverseJoinColumn;

#[Entity]
#[Table(name: "Groupe")]
class Groupe
{
    #[Id]
    #[Column(name: "id_groupe", type: 'integer')]
    #[GeneratedValue(strategy: 'AUTO')]
    private int $id_groupe;

    #[Column(name: 'name', length: 100, unique: true)]
    private $name;

    #[OneToMany(targetEntity: User::class, mappedBy: 'groupe')]
    private ORMPersistentCollection $users;

    #[ManyToMany(targetEntity: Role::class)]
    #[JoinTable(name: 'Groupe_Role')]
    #[JoinColumn(name: 'id_groupe', referencedColumnName: 'id_groupe')]
    #[InverseJoinColumn(name: 'id_role', referencedColumnName: 'id_role')]
    private ORMPersistentCollection $roles;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->roles = new ArrayCollection();
    }

    /**
     * Getter
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }
    public function getId(): int
    {
        return $this->id_groupe;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getUsers(): ORMPersistentCollection
    {
        return $this->users;
    }

    /**
     * Setter
     */
    public function setRole(Collection $roles): void
    {
        $this->roles = $roles;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setUsers(Collection $users): void
    {
        $this->users = $users;
    }
}
