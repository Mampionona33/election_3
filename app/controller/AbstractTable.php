<?php

namespace ControllerNamespace;

use Doctrine\ORM\EntityManager;

abstract class AbstractTable
{
    protected string $name;
    protected $columns;
    protected EntityManager $entityManager;
    protected $bootstrap;
    abstract protected function initializeEntityManager(): void;
}
