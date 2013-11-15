<?php class SessionsController extends ApplicationController
{

    public function fresh()
    {
        static $session;
        $session = new UserSession();
    }

    public function create()
    {
        static $session;
        $session = new UserSession($this->params['login']);
        if ($session->wasCreate()) {
            Flash::message('success', 'Login realizado com sucesso!');
            $this->redirect_to('/');
        } else {
            Flash::message('danger', 'Login/senha incorretas!');
        }
        $this->view = 'sessions/fresh';
    }

    public function destroy()
    {
        $session = new UserSession();
        $session->destroy();
        Flash::message('warning','Usuário deslogado!');
        $this->redirect_to('/');
    }
}
