<?php

class ServicesController extends ApplicationController
{

    public function beforeAction($action)
    {
        $roles = [
            'show' => 1,
            'fresh' => 1,
            'create' => 1,
            'destroy' => 2
        ];
        parent::beforeAction($action, $roles);
        $this->countAccommodations = Accommodation::countActiveAccommodations();
    }

    public function index()
    {
        $this->services = Service::last();
    }

    public function history()
    {
        $this->services = false;
        $this->search = new Field('search');
        if( isset( $this->params['search'] ) ){
            $searching = $this->params['search'];
            $this->search->setValue($searching);
            $this->services = Service::like($searching);
        }
    }

    public function fresh()
    {
        $this->accommodation = Accommodation::find($this->params[':id']);
        $this->service = new Service();
        $this->types = ServiceType::forSelect();
    }

    public function create()
    {
        $this->accommodation = Accommodation::find($this->params[':id']);
        $this->types = ServiceType::forSelect();
        $this->service = new Service($this->params['service']);
        if ($this->service->save()) {
            Flash::message('success', 'Serviço criado com sucesso!');
            $this->redirect_to('/servicos');
        } else {
            Flash::message('danger', 'Não foi possível criar o serviço! Verifique o formulário!');
        }
        $this->view = 'services/fresh';
    }


    public function show()
    {
        $this->service = Service::findBelongs($this->params[':id'], [
            'belongs' => [
                ['table' => 'service_types', 'through' => 'service_type_id'],
                ['table' => 'accommodations', 'through' => 'accommodation_id'],
            ]
        ]);
    }


    public function destroy()
    {
        $this->service = Service::find($this->params[':id']);
        if ($this->service->destroy()) {
            Flash::message('success', 'Serviço cancelado com sucesso!');
        } else {
            Flash::message('danger', 'Não foi possível cancelar o serviço!');
        }
        $this->redirect_to( '/servicos' );
    }


}