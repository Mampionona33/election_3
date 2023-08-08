<?php

namespace Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'Authorization')]
class Authorization
{
    #[Id]
    #[Column(name: "id_authorization", type: 'integer')]
    #[GeneratedValue(strategy: 'AUTO')]
    private int $id;
    #[Column(name: 'slug', length: 100, unique: true)]
    private $slug;
    #[Column(name: 'label', length: 100, unique: true)]
    private $label;
    #[ManyToMany(targetEntity: Groupe::class, mappedBy: 'authorization')]
    private Collection $groupe;
}
