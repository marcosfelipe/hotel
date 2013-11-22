<?php class SessionsController extends ApplicationController
{

    public function fresh()
    {
        $this->session = new UserSession();
    }

    public function newPassword()
    {
        if (isset($_SESSION['pass_token'])) {
            $expire = time() - 120;
            if ($_SESSION['pass_token'] < $expire) {
                Flash::message('danger', 'A sessão para atualização da senha expirou!');
                $this->redirect_to('/home');
            }
            $this->user = new UserSession();
        } else{
            Flash::message('danger', 'Você não pode acessar esta página!');
            $this->redirect_to('/home');
        }
        $this->view = 'sessions/new_password';
    }

    public function createPassword()
    {
        if ($this->params['password'] == $this->params['password_confirmation'] && !empty($this->params['password'])) {
            $this->currentUser()->update(['password' => $this->params['password']]);
            Flash::message('success', 'Senha criada com sucesso!');
            $this->redirect_to('/home');
        }
        Flash::message('danger', 'Insira uma senha válida nos dois campos!');
        $this->view = 'sessions/new_password';
    }

    public function create()
    {
        $this->session = new UserSession($this->params['login']);
        $user = $this->session->wasCreate();
        if ($user) {
            Flash::message('success', 'Login realizado com sucesso!');
            if ($user->password->getValue() == '') {
                $token = time();
                $_SESSION['pass_token'] = $token;
                $this->redirect_to("/nova-senha");
            }
            $this->redirect_to('/');
        } else {
            Flash::message('danger', 'Login/senha incorretas!');
        }
        $this->view = 'sessions/fresh';
    }

    public function destroy()
    {
        UserSession::destroySession();
        Flash::message('warning', 'Usuário deslogado!');
        $this->redirect_to('/');
    }
}
