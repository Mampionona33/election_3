<?php

namespace Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "Role")]
class Role
{
    #[Id]
    #[Column(name: "id_role", type: 'integer')]
    #[GeneratedValue(strategy: 'AUTO')]
    private int $id;
    #[Column(name: 'slug', length: 100, unique: true)]
    private $slug;
    #[Column(name: 'label', length: 100, unique: true)]
    private $label;

    /**
     * Getter
     */
    public function getSlug(): string
    {
        return $this->slug;
    }
    public function getLabel(): string
    {
        return $this->label;
    }
    public function getId(): int
    {
        return $this->id;
    }
}
