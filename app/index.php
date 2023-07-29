<?php
// Gestion des erreurs probables


error_reporting(E_ALL);
ini_set('display_errors', '1');
// ----------------------------

require 'vendor/autoload.php';

final class App
{

    /**
     * getter and setter
     */

    // --------------------------------------
    public function __construct()
    {
    }


    public function __invoke()
    {
    }
}

$app = new App();
$app();
