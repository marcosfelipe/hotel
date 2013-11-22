<?php

class ClientsController extends ApplicationController
{

    public function beforeAction($action)
    {
        $roles = [
            'all' => '1',
        ];
        parent::beforeAction($action, $roles);
    }

    private function enterprisesSelect(){
        return Enterprise::allS(array('fields' => 'id as value,name as option'));
    }

    public function index()
    {
        $this->clients = Client::joins('LEFT JOIN enterprises ON clients.enterprise_id = enterprises.id
            WHERE clients.active = true',
            ['fields' => 'clients.id as client_id,
                clients.name as client_name, clients.cpf as client_cpf,
                enterprises.name as enterprise_name,
                enterprises.id as enterprise_id']);
    }

    public function fresh()
    {
        $this->client = new Client();
        $this->enterprises = $this->enterprisesSelect();
    }

    public function create()
    {
        $this->enterprises = $this->enterprisesSelect();
        $this->client = new Client($this->params['client']);
        if ($this->client->save()) {
            Flash::message('success', 'Novo cliente criado com sucesso!');
            $this->redirect_to('/clientes');
        } else {
            Flash::message('danger', 'O formulário contém erros!');
        }
        $this->view = 'clients/fresh';
    }

    public function update()
    {
        $this->enterprises = $this->enterprisesSelect();
        $this->client = Client::find($this->params[':id']);
        $this->client->setData($this->params['client']);
        if ($this->client->update()) {
            Flash::message('success', 'Cliente editado com sucesso!');
            $this->redirect_to('/clientes');
        } else {
            Flash::message('danger', 'O formulário contém erros!');
        }
        $this->view = 'clients/edit';
    }

    public function destroy()
    {
        $this->client = Client::find($this->params[':id']);
        if ($this->client->destroy()) {
            Flash::message('success', 'Cliente excluido com sucesso!');
        } else {
            Flash::message('danger', 'Erro ao excluir o cliente!');
        }
        $this->redirect_to('/clientes');
    }

    public function show()
    {
        $this->client = Client::findBelongs($this->params[':id'],
            ['belongs' => [
                    ['table' => 'enterprises', 'through' => 'enterprise_id']
                ]
            ]
        );
    }

    public function edit()
    {
        $this->enterprises = $this->enterprisesSelect();
        $this->client = Client::find($this->params[':id']);
    }

}