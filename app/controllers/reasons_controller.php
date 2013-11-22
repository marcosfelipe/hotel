<?php

class ReasonsController extends ApplicationController{


    public function beforeAction($action){
        $roles = [
            'all' => 1
        ];
        parent::beforeAction($action,$roles);
    }

    public function index(){
        $this->reasons = Reason::allS();
    }

    public function fresh(){
        $this->reason = new Reason();
    }

    public function create(){
        $this->reason = new Reason( $this->params['reason'] );
        if( $this->reason->save() ){
            Flash::message('success','Novo motivo adicionado com sucesso!');
            $this->redirect_to('/motivos');
        }else{
            Flash::message('danger','O formulário contém erros!');
        }
        $this->view = 'reasons/fresh';
    }

    public function update(){
        $this->reason = Reason::find( $this->params[':id'] );
        $this->reason->setData( $this->params['reason'] );
        if( $this->reason->update() ){
            Flash::message('success','Motivo editado com sucesso!');
            $this->redirect_to('/motivos');
        }else{
            Flash::message('danger','O formulário contém erros!');
        }
        $this->view = 'reasons/edit';
    }

    public function destroy(){
        $this->reason = Reason::find( $this->params[':id'] );
        if( $this->reason->destroy() ){
            Flash::message('success','Motivo excluido com sucesso!');
        }else{
            Flash::message('danger','Erro ao excluir o motivo!');
        }
        $this->redirect_to('/motivos');
    }

    public function show(){
        $this->reason = Reason::find($this->params[':id']);
    }

    public function edit(){
        $this->reason = Reason::find($this->params[':id']);
    }

}