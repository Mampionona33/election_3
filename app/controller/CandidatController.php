<?php

namespace ControllerNamespace;

use ModelNamespace\CandidatModel;
use ServiceNamespace\UserService;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class CandidatController
{
    private $twig;
    private $loader;
    private $candidatModel;
    private $authController;
    private $userService;
    private $firstCandidat;
    private $candidatMaxPoint;
    private $result;
    /**
     * getter and sette
     */
    public function setResult(string $result): void
    {
        $this->result = $result;
    }
    public function  getResult(): string
    {
        return $this->result;
    }
    public function setFirstCandidat(array $firstCandidat): void
    {
        $this->firstCandidat = $firstCandidat;
    }
    public function getFirsCandidat(): array
    {
        return $this->firstCandidat;
    }
    public function setCandidatMaxPoint(array $candidatMaxPoint): void
    {
        $this->candidatMaxPoint = $candidatMaxPoint;
    }
    public function getCandidatMaxPoint(): array
    {
        return $this->candidatMaxPoint;
    }
    public function setUserService(UserService $userService): void
    {
        $this->userService = $userService;
    }
    public function getUserService(): UserService
    {
        return $this->userService;
    }
    public function setAuthController(AuthController $authController): void
    {
        $this->authController = $authController;
    }

    public function getAuthController(): AuthController
    {
        return $this->authController;
    }

    public function setCandidatModel(CandidatModel $candidatModel): void
    {
        $this->candidatModel = $candidatModel;
    }
    public function  getCandidatModel(): CandidatModel
    {
        return $this->candidatModel;
    }
    public function setLoader(FilesystemLoader $loader): void
    {
        $this->loader = $loader;
    }

    public function getLoader(): FilesystemLoader
    {
        return $this->loader;
    }
    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }

    public function getTwig(): Environment
    {
        return $this->twig;
    }
    // -----------------------------
    public function __construct()
    {
        $this->setCandidatModel(new CandidatModel());
        $this->setLoader(new FilesystemLoader(__DIR__ . '/../template'));
        $this->setTwig(new Environment($this->loader));
    }

    public function caluclResult()
    {
        $this->setCandidatMaxPoint($this->candidatModel->getCandidatWithMaxPoint());
        $this->setFirstCandidat($this->candidatModel->getFirstCandidat());

        if (!empty($this->getFirsCandidat()) && !empty($this->getCandidatMaxPoint())) {
            if (!empty(array_diff($this->getFirsCandidat()[0], $this->getCandidatMaxPoint()[0]))) {
                if ($this->getFirsCandidat() >= 12.5) {
                    // $this->setResult("Le candidat $this->getFirsCandidat()[0][name]");
                }
            }
        }

        return $this->candidatModel->customGetAll();
    }



    public function handleGet(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            if ($this->authController->isUserLogged()) {
                echo $this->getTwig()->render("candidatpage.html.twig", ["services" => $this->userService->provideUserData(), "candidats" => $this->candidatModel->customGetAll()]);
            } else {
                echo $this->getTwig()->render("not authorised");
            }
        }
    }
}
