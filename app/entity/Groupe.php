<?php

namespace Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
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
}