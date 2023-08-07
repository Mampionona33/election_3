<?php

namespace ControllerNamespace\table;

use App\Bootstrap;
use Doctrine\ORM\EntityManager;

abstract class AbstractTable
{
    protected string $name;
    protected array $columns;
    protected Bootstrap $bootstrap;
    protected EntityManager $entityManager;
}
