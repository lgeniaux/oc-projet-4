<?php

class HomeController
{
    public function showHome(): void
    {
        $view = new View('Accueil');
        $view->render('home');
    }
}
