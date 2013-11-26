<?php

class UsersController extends ApplicationController
{

    public function edit(){
        $this->user = User::find($this->currentUser()->id->getValue(),['table' => 'employees']);
        $this->view = 'users/profile';
    }

    public function update(){
        $this->user = User::find($this->currentUser()->id->getValue(),['table' => 'employees']);
        $this->user->setData($this->params['user']);
        if ($this->user->update()) {
            Flash::message('success', 'Perfil editado com sucesso!');
        } else {
            Flash::message('danger', 'O formulário contém erros!');
        }
        $this->view = 'users/profile';
    }

    public function changePassword(){
        $token = time();
        $_SESSION['pass_token'] = $token;
        $this->redirect_to("/nova-senha");
    }

}

?>
