<?php

class RoomTypesController extends ApplicationController{

    public function index(){
        $this->types = RoomType::allS();
    }

    public function fresh(){
        $this->type = new RoomType();
    }

    public function create(){
        $this->type = new RoomType( $this->params['type'] );
        if( $this->type->save() ){
            Flash::message('success','Novo tipo de acomodação criado com sucesso!');
            $this->redirect_to('/acomodacoes-tipos');
        }else{
            Flash::message('danger','O formulário contém erros!');
        }
        $this->view = 'room_types/fresh';
    }

    public function update(){
        $this->type = RoomType::find( $this->params[':id'] );
        $this->type->setData( $this->params['type'] );
        if( $this->type->update() ){
            Flash::message('success','Tipo de acomodação editado com sucesso!');
            $this->redirect_to('/acomodacoes-tipos');
        }else{
            Flash::message('danger','O formulário contém erros!');
        }
        $this->view = 'room_types/edit';
    }

    public function destroy(){
        $type = RoomType::find( $this->params[':id'] );
        if( $type->destroy() ){
            Flash::message('success','Tipo de acomodação excluido com sucesso!');
        }else{
            Flash::message('danger','Erro ao excluir o tipo!');
        }
        $this->redirect_to('/acomodacoes-tipos');
    }

    public function show(){
        $this->type = RoomType::find($this->params[':id']);
    }

    public function edit(){
        $this->type = RoomType::find($this->params[':id']);
    }

}