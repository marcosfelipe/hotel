<?php abstract class BaseController
{

    private $viewVars = array();
    public $view;
    protected $params;
    protected $beforeAction;

    public function setParams($params)
    {
        $this->params = $params;
    }

    /*
     * adiciona no array viewVars
     * para extração de variaveis na view
     */
    public function set( $data1, $data2=null ){
        if( is_array($data1) ){
            foreach($data1 as $key => $row ){
                $this->viewVars[ $key ] = $row;
            }
        }else{
            $this->viewVars[ $data1 ] = $data2;
        }
    }

    /*
     * paths helper contem array de funções para as urls
     */
    public function render($vars = array())
    {
        require 'core/views/views_helpers_functions.php';
        $layout = 'layout/application.phtml';

        if (isset($this->viewVars['layout']) && $this->viewVars['layout'])
            $layout = $this->viewVars['layout'];

        $vars = array_merge(
            array(
                'url_helpers' => array(),
                'static_vars' => array(),
            ),
            $vars
        );

        extract($vars['url_helpers']);
        extract($vars['static_vars']);
        extract($this->viewVars);

        $view = 'views/' . $this->view.'.phtml';
        require 'views/' . $layout;
        exit();
    }

    /*
     * Método destinada ao redirecionamento de páginas
     * Lembre-se que quando um endereço inicia-se com '/' diz respeito
     * a um caminho absoluto, caso contrário é um caminho relativo.
     */
    protected function redirect_to($address)
    {
        if (substr($address, 0, 1) == '/')
            header('location: ' . SITE_ROOT . $address);
        else
            header('location: ' . $address);
        exit();
    }

    /*
     * Retorna o endereço da última página carregada,
     * caso não exista retorna o endereço da página principal da aplicação
     */
    protected function back()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            return $_SERVER['HTTP_REFERER'];
        } else {
            return '/';
        }
    }


    public function beforeAction($action)
    {
        if (sizeof($this->beforeAction) >= 2) {
            $actions = explode(';', $this->beforeAction[0]);
            $method = $this->beforeAction[1];

            if (in_array('all', $actions) || in_array($action, $actions)) {
                $this->$method();
            }
        }
    }


}

?>
