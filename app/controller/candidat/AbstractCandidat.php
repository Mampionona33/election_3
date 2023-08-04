<?php

namespace ControllerNamespace\candidat;

use Lib\AppEntityManage;

abstract class AbstractCandidat
{
    protected string $name;
    protected int $nbVoix;
    protected int $voicePercentage;
    protected AppEntityManage $appEntityManage;
    protected string $query;
    abstract protected function getDataByQueryFromDb(): array;
}
