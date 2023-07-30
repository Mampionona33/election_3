<?php

namespace ControllerNamespace;

use Doctrine\ORM\EntityManager;

class CreateTableIfNotExiste
{
    private $entityManager;

    /**
     * setter
     */
    public function setEntityManager(EntityManager $entityManager): void
    {
        $this->entityManager = $entityManager;
    }
    /**
     * Getter
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    
}
