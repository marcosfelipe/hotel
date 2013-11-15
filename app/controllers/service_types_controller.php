<?php

class ServiceTypesController extends ApplicationController{

    public function index(){
        $this->types = ServiceType::allS();
    }

    public function fresh(){
        $this->type = new ServiceType();
    }

    public function create(){
        $this->type = new ServiceType( $this->params['type'] );
        if( $this->type->save() ){
            Flash::message('success','Novo tipo de serviço criado com sucesso!');
            $this->redirect_to('/servicos-tipos');
        }else{
            Flash::message('danger','O formulário contém erros!');
        }
        $this->view = 'service_types/fresh';
    }

    public function update(){
        $this->type = ServiceType::find( $this->params[':id'] );
        $this->type->setData( $this->params['type'] );
        if( $this->type->update() ){
            Flash::message('success','Tipo de serviço editado com sucesso!');
            $this->redirect_to('/servicos-tipos');
        }else{
            Flash::message('danger','O formulário contém erros!');
        }
        $this->view = 'service_types/edit';
    }

    public function destroy(){
        $type = ServiceType::find( $this->params[':id'] );
        if( $type->destroy() ){
            Flash::message('success','Tipo de serviço excluido com sucesso!');
        }else{
            Flash::message('danger','Erro ao excluir o tipo!');
        }
        $this->redirect_to('/servicos-tipos');
    }

    public function show(){
        $this->type = ServiceType::find($this->params[':id']);
    }

    public function edit(){
        $this->type = ServiceType::find($this->params[':id']);
    }

}