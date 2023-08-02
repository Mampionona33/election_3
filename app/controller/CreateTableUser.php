<?php

namespace ControllerNamespace;


class CreateTableUser extends CreateTableIfNotExiste
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("User");
    }
}
