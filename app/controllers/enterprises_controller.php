<?php

class EnterprisesController extends ApplicationController
{

    public function beforeAction($action){
        $roles = [
            'all' => '1',
        ];
        parent::beforeAction($action,$roles);
    }

    public function index()
    {
        $this->enterprises = Enterprise::allS();
    }

    public function fresh()
    {
        $this->enterprise = new Enterprise();
    }

    public function create()
    {
        $this->enterprise = new Enterprise($this->params['enterprise']);
        if ($this->enterprise->save()) {
            Flash::message('success', 'Nova empresa criada com sucesso!');
            $this->redirect_to('/empresas');
        } else {
            Flash::message('danger', 'O formulário contém erros!');
        }
        $this->view = 'enterprises/fresh';
    }

    public function update()
    {
        $this->enterprise = Enterprise::find($this->params[':id']);
        $this->enterprise->setData($this->params['enterprise']);

        if ($this->enterprise->update()) {
            Flash::message('success', 'Empresa editada com sucesso!');
            $this->redirect_to('/empresas');
        } else {
            Flash::message('danger', 'O formulário contém erros!');
        }
        $this->view = 'enterprises/edit';
    }

    public function destroy()
    {
        $this->enterprise = Enterprise::find($this->params[':id']);
        if ($this->enterprise->destroy()) {
            Flash::message('success', 'Empresa excluida com sucesso!');
        } else {
            Flash::message('danger', 'Erro ao excluir a empresa!');
        }
        $this->redirect_to('/empresas');
    }

    public function show()
    {
        $this->enterprise = Enterprise::find($this->params[':id']);
    }

    public function edit()
    {
        $this->enterprise = Enterprise::find($this->params[':id']);
    }

}