<?php

class ProductTypesController extends ApplicationController{

    public function index(){
        static $types;
        $types = ProductType::allS();
    }

    public function fresh(){
        static $type;
        $type = new ProductType();
    }

    public function create(){
        static $type;
        $type = new ProductType( $this->params['type'] );
        if( $type->save() ){
            Flash::message('success','Novo tipo criado com sucesso!');
            $this->redirect_to('/produtos-tipos');
        }else{
            Flash::message('danger','O formulário contém erros!');
        }
        $this->view = 'product_types/fresh';
    }

    public function update(){
        static $type;
        $type = ProductType::find( $this->params[':id'] );
        $type->setData( $this->params['type'] );
        if( $type->update() ){
            Flash::message('success','Tipo editado com sucesso!');
            $this->redirect_to('/produtos-tipos');
        }else{
            Flash::message('danger','O formulário contém erros!');
        }
        $this->view = 'product_types/edit';
    }

    public function destroy(){
        $type = ProductType::find( $this->params[':id'] );
        if( $type->destroy() ){
            Flash::message('success','Tipo excluido com sucesso!');
        }else{
            Flash::message('danger','Erro ao excluir o motivo!');
        }
        $this->redirect_to('/produtos-tipos');
    }

    public function show(){
        static $type;
        $type = ProductType::find($this->params[':id']);
    }

    public function edit(){
        static $type;
        $type = ProductType::find($this->params[':id']);
    }

}