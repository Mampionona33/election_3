<?php

namespace ControllerNamespace;

use ControllerNamespace\table\CreateTableIfNotExiste;

class CreateTableUser extends CreateTableIfNotExiste
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("User");
    }
}
