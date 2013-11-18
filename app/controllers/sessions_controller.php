<?php class SessionsController extends ApplicationController
{

    public function fresh()
    {
        $this->session = new UserSession();
    }

    public function create()
    {
        $this->session = new UserSession($this->params['login']);
        if ($this->session->wasCreate()) {
            Flash::message('success', 'Login realizado com sucesso!');
            $this->redirect_to('/');
        } else {
            Flash::message('danger', 'Login/senha incorretas!');
        }
        $this->view = 'sessions/fresh';
    }

    public function destroy()
    {
        UserSession::destroySession();
        Flash::message('warning','Usuário deslogado!');
        $this->redirect_to('/');
    }
}
