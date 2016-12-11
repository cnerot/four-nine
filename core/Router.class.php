<?php

class Router
{
    /**
     * This method will parse the client REQUEST_URI in order to determine a controller name and an action name.
     * @return array
     */
    public static function parseRoute()
    {
        $request = trim($_SERVER['REQUEST_URI'], '/');
        $uri = explode('/', explode('?', $request)[0]);

        $controller = !empty($uri[0]) ? $uri[0] : 'index';
        $action = !empty($uri[1]) ? $uri[1] : 'index';

        unset($uri[0]);
        unset($uri[1]);

        $args = array_merge($uri, $_REQUEST);
        return ['controller' => $controller, 'action' => $action, 'args' => $args];
    }

    /**
     * This method will call Router::parseRoute() to determine the controller/action, then will call the action.
     * If the action / controller does not exists, it will generate a 404 error.
     */
    public static function route()
    {
        $route = self::parseRoute();
        $controllerName = ucfirst($route['controller']) . 'Controller';
        $methodName = $route['action'] . 'Action';

        $controllerPath = Config::CONTROLLER_PATH . DIRECTORY_SEPARATOR . $controllerName . '.class.php';
        if (file_exists($controllerPath)) {
            include $controllerPath;

            $controller = new $controllerName;

            if (method_exists($controller, "preDeploy")) {
                $controller->preDeploy($route['args']);
            }
            if (method_exists($controller, $methodName)) {
                $controller->$methodName($route['args']);
            } else {
                HTTPError::generate404('Cette action n\'existe pas');
            }
            if (method_exists($controller, "postDeploy")) {
                $controller->preDeploy($route['args']);
            }
        } else {
            HTTPError::generate404('Controlleur introuvable');
        }
    }

    /**
     * Generates URL from controller & action and params
     */
    public static function getUrl($controller, $action, $data = [])
    {
        $request = trim($_SERVER['REQUEST_URI'], '/');
        $uri = explode('/', explode('?', $request)[0]);
        $current_controller = !empty($uri[0]) ? $uri[0] : 'index';
        $current_action = !empty($uri[1]) ? $uri[1] : 'index';

        if ($controller != "*"){$current_controller = $controller;}
        if ($action != "*"){$current_action = $action;}

        $return_url = Config::URL . $current_controller . "/" . $current_action;
        if (!empty($data)){
            $return_url .= "?";
        }
        $return_url .= http_build_query($data);
        return $return_url;
    }

}