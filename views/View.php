<?php

class View
{
    private string $title;
    private int $unreadMessagesCount;

    public function __construct(string $title)
    {
        $this->title = $title;
        $this->unreadMessagesCount = MessageService::countUnreadMessagesForCurrentUser();
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
        $unreadMessagesCount = $this->unreadMessagesCount;
        $activeNav = Utils::request('action', 'home');
        if ($activeNav === 'book') {
            $activeNav = 'books';
        }
        if ($activeNav === 'register') {
            $activeNav = 'login';
        }
        if ($activeNav === 'profile') {
            $activeNav = 'myprofile';
        }
        if (in_array($activeNav, ['add-book', 'edit-book'], true)) {
            $activeNav = 'myprofile';
        }

        require MAIN_VIEW_PATH;
    }
}
