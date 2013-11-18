<?php class Router
{

    private $url;
    private $post_routes = array();
    private $get_routes = array();

    public function __construct($url)
    {
        $this->url = str_replace(SITE_ROOT, '', $url);
    }

    public function get($route, $options)
    {
        $this->get_routes[$route] = $options;
    }

    public function post($route, $options)
    {
        $this->post_routes[$route] = $options;
    }

    public function load()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $this->find($this->post_routes);
        else
            $this->find($this->get_routes);
    }

    public static function snakeToCamel($val)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));
    }

    public static function camelToSnake($val)
    {
        return preg_replace_callback('/[A-Z]/',
            create_function('$match', 'return "_" . strtolower($match[0]);'),
            lcfirst($val));
    }


    private static function parseController($str)
    {
        return self::camelToSnake(lcfirst(str_replace('Controller', '', $str)));
    }


    /*
     * urlsHelper CRIA UM HELPER PARA URL
     * por exemplo: acesso a
     * /pagina/acao/id  ===>  $path_pagina_acao($id) ou $path_pagina_acao()
     *
     */

    private function urlsHelper()
    {
        $paths = [];
        foreach (array($this->get_routes, $this->post_routes) as $routes) {
            foreach ($routes as $route => $options) {

                $params = [];
                $route1 = explode('/', $route);
                $url1 = explode('/', $this->url);

                for ($i = 0; $i < sizeof($route1); $i++) {
                    if (preg_match('/^:[a-z,_]+$/', $route1[$i])) {
                        $params[$route1[$i]] = isset($url1[$i]) ? $url1[$i] : '';
                    }
                }

                $fun = Router::camelToSnake(self::parseController($options['controller']) . '_' . $options['action']);
                $fun .= '_path';

                $paths[$fun] = create_function(
                    '$id = ""',
                    '
                    $url = "' . $route . '";
                $url = str_replace(":id", $id, "' . $route . '");
                return SITE_ROOT.$url;
            ');
            }
        }
        return $paths;
    }


    private function find($routes)
    {
        foreach ($routes as $route => $options) {

            $params = [];

            if ($this->isRightRoute($route, $params)) {

                Logger::getInstance()->log("match: {$route} with {$this->url}", Logger::NOTICE);
                $controller_name = $options['controller'];
                $action_name = $options['action'];

                $merged_params = array_merge($this->params(), $params);

                $controller = new $controller_name();

                $controller->beforeAction($action_name);
                $controller->setParams($merged_params);
                $controller->$action_name();

                if (empty($controller->view))
                    $controller->view = self::parseController($controller_name) . "/$action_name";

                /**
                 * Paga as variaveis definidas como static para
                 * extrair pra view
                 */
                $method = new ReflectionMethod($controller_name, $action_name);
                $method_vars = $method->getStaticVariables();

                $controller->render(
                    array(
                        'url_helpers' => $this->urlsHelper(),
                        'static_vars' => $method_vars
                    )
                );

                return;
            }
        }
        $this->page_not_found();
    }

    private function isRightRoute($route, &$params)
    {
        $route = explode('/', $route);
        $url = explode('/', $this->url);

        if (sizeof($route) != sizeof($url)) return false;

        for ($i = 0; $i < sizeof($route); $i++) {
            if (preg_match('/^:[a-z,_]+$/', $route[$i])) {
                $params[$route[$i]] = $url[$i];
                continue;
            } else if ($route[$i] !== $url[$i]) {
                return false;
            }
        }
        return true;
    }

    private function params()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            return $_POST;
        else
            return $_GET;
    }

    private function page_not_found()
    {
        Logger::getInstance()->log("URL NOT FOUND: " . $_SERVER['REQUEST_URI'], Logger::ERROR);
        Flash::message('danger', 'Página não encontrada!');
        header('location: ' . SITE_ROOT . '/');
        exit();
    }
}

?>
