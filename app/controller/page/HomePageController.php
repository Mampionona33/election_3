<?php

namespace ControllerNamespace\page;

class HomePageController extends BasePage
{
    public function __construct()
    {
        parent::__construct();
    }

    public function render(): void
    {
        echo $this->getTwig()->render("homepage.html.twig");
    }
}
