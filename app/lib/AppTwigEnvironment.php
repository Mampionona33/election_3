<?php

namespace Lib;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

final class AppTwigEnvironment extends Environment
{
    private static $instance;
    private $filesystemLoader;
    private $twig;

    /**
     * Getter
     */
    public function getTwig()
    {
        return $this->twig;
    }
    public function getLoader(): FilesystemLoader
    {
        return $this->filesystemLoader;
    }

    /**
     * Setter
     */
    public function setLoader(LoaderInterface $filesystemLoader): void
    {
        $this->filesystemLoader = $filesystemLoader;
    }

    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }

    private function __construct()
    {
        $this->setLoader(new FilesystemLoader(__DIR__ . "/../template"));
        $this->setTwig(new Environment($this->getLoader()));
    }

    /**
     * Singleton instance
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
