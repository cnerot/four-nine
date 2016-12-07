<?php

/**
 * HTTP Errors
 */
class HTTPError
{
    public static function generate404($message = false)
    {
        header('404 Not Found');

        $view = new View();
        $view->setView('404');
        $view->putData('message', $message);
    }

    public static function generate500($message = false, $details = false)
    {
        header('500 Internal Server Error');
        echo '<h1>500 Erreur du serveur</h1>';
        if ($message) {
            echo '<p>' . $message . '</p>';
        }

        if(Config::ENV_DEBUG && $details) {
            echo '<pre>' . $details . '</pre>';
        }
    }
}