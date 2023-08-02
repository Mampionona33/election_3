<?php

namespace ServiceNamespace;

class Service
{
    private static array $appData;

    public function addAppData(string $dataKey, $dataValue): void
    {
        self::$appData[$dataKey] = $dataValue;
    }

    public static function getAppData(): array
    {
        return self::$appData;
    }
}
