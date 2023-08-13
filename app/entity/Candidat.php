<?php

namespace Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'Candidat')]
class Candidat
{
    #[Id]
    #[Column(name: 'id_candidat', type: 'integer')]
    #[GeneratedValue(strategy: 'AUTO')]
    private int $id;
    #[Column(name: 'name', length: 100, unique: true)]
    private $name;
    #[Column(name: 'nbVoix', type: 'integer')]
    private $nbVoix;

    /**
     * Getter
     */
    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getNbVoix(): int
    {
        return $this->nbVoix;
    }
    /**
     * Setter
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setNbVoix(int $nbVoix): void
    {
        $this->nbVoix = $nbVoix;
    }
}
