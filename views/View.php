<?php

class View
{
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function render(string $viewName, array $params = []): void
    {
        $viewPath = TEMPLATE_VIEW_PATH . $viewName . '.php';

        if (!file_exists($viewPath)) {
            throw new Exception("La vue demandée n'existe pas.");
        }

        extract($params);

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        $title = $this->title;

        require MAIN_VIEW_PATH;
    }
}
