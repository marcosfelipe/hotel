<?php

class UsersController extends ApplicationController
{


    public function _new()
    {
        $this->render(array('view' => 'users/fresh.phtml',
            'user' => new User()));
    }

    public function create()
    {
        $user = new User($this->params['user']);
        if ($user->save()) {
            Flash::message('success', 'Registro realizado com sucesso!');
            $this->redirect_to('/login');
        } else {
            Flash::message('danger', 'Existe dados incorretos no seu formulário!');
            $this->render(array('view' => 'users/fresh.phtml',
                'layout' => 'layout/unauthenticated.phtml',
                'user' => $user));
        }
    }

    public function edit()
    {
        $this->render(array('view' => 'users/edit.phtml',
            'user' => $this->currentUser()));

    }

    public function update()
    {
        $user = $this->currentUser();

        if ($user->update($this->params['user'])) {
            Flash::message('success', ' Atualização realizada com sucesso!');
            $this->redirect_to('/');
        } else {
            Flash::message('danger', 'Existe dados incorretos no seu formulário!');
            $this->render(array('view' => 'users/edit.phtml', 'user' => $user));
        }
    }
}

?>
