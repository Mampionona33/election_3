<?php

namespace Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Candidat
{
    #[Id]
    #[Column(name: 'id_candidat', type: 'integer')]
    #[GeneratedValue(strategy: 'AUTO')]
    private int $id;
    #[Column(name: 'name', length: 100, unique: true)]
    private $name;
    #[Column(name: 'nb_voix', type: 'integer')]
    private $nb_voix;

    /**
     * Getter
     */
    public function getName(): string
    {
        return $this->name;
    }
    public function getNbVoix(): int
    {
        return $this->nb_voix;
    }
    /**
     * Setter
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setNombredDeVoix(int $nb_voix): void
    {
        $this->nb_voix = $nb_voix;
    }
}
