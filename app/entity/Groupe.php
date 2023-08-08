<?php

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "Groupe")]
class Groupe
{
    #[Id]
    #[Column(name: "id_groupe", type: 'integer')]
    #[GeneratedValue(strategy: 'AUTO')]
    private int $id;
    #[Column(name: 'name', length: 100, unique: true)]
    private $name;
    #[OneToMany(targetEntity: User::class, mappedBy: 'groupe')]
    private Collection $users;

    #[OneToMany(targetEntity: Authorization::class, mappedBy: 'authorization')]
    private Collection $authorization;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }
}
