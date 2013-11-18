<?php class ApplicationController extends BaseController
{
    private $currentUser;

    public function currentUser()
    {
        if( isset($_SESSION['user']['id']) ){
            $currentUser = Employee::find($_SESSION['user']['id']);
            return $currentUser;
        }
        return false;
    }

    /*
     * implementação do metodo before action com roles
     */
    public function beforeAction($action,$actions = []){
        if ( count($actions)>0 ) {
            if (array_key_exists($action, $actions) ){
                if( $this->currentUser() == null ) $this->redirect_to('/login');
                if( $this->currentUser()->level->getValue() < $actions[ $action ] ){
                    Flash::message('danger','Você não tem permissões para acessar esta página!');
                    $this->redirect_to('/home');
                }
            }elseif( array_key_exists('all', $actions) ){
                if( $this->currentUser() == null ) $this->redirect_to('/login');
                if( $this->currentUser()->level->getValue() < $actions[ 'all' ] ){
                    Flash::message('danger','Você não tem permissões para acessar esta página!');
                    $this->redirect_to('/home');
                }
            }
        }
    }


}
