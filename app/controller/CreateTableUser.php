<?php

namespace ControllerNamespace;

use Entity\User;

class CreateTableUser extends CreateTable
{
    public function __construct()
    {
        echo ("test " . $this->initializeEntityManager());

        $this->setName("User");
        var_dump($this->name);
        $this->setColumns($this->entityManager->getClassMetadata(User::class));
    }
}
