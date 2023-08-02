<?php

namespace ControllerNamespace\candidat;

use ControllerNamespace\CreateTableIfNotExiste;

class CreateTableCandidat extends CreateTableIfNotExiste
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("Candidat");
    }
}
