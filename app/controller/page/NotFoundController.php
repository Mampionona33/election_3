<?php

namespace ControllerNamespace\page;

class NotFoundController
{
    public function notFound(array $data): void
    {
        echo "<h3>Whoops! 404 Page not found</h3>";
    }
}
