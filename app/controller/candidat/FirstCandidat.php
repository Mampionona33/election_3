<?php

namespace ControllerNamespace\candidat;

use Entity\Candidat;

class FirstCandidat extends CandidatBase
{
    public function __construct()
    {
        parent::__construct();
        $this->setQuery('SELECT c FROM Entity\Candidat c WHERE c.id = (SELECT MIN(c2.id) FROM Entity\Candidat c2)');
    }
}
