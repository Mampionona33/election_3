<?php

namespace ControllerNamespace;

abstract class AbstractTable
{
    private $name;
    private $columns;
    abstract public function create();
}
