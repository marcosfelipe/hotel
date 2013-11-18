<?php

class PaymentTypesController extends ApplicationController{

    public function index(){
        $this->types = PaymentType::allS();
    }

    public function fresh(){
        $this->type = new PaymentType();
    }

    public function create(){
        $this->type = new PaymentType( $this->params['type'] );
        if( $this->type->save() ){
            Flash::message('success','Novo tipo de pagamento criado com sucesso!');
            $this->redirect_to('/pagamentos-tipos');
        }else{
            Flash::message('danger','O formulário contém erros!');
        }
        $this->view = 'payment_types/fresh';
    }

    public function update(){
        $this->type = PaymentType::find( $this->params[':id'] );
        $this->type->setData( $this->params['type'] );
        if( $this->type->update() ){
            Flash::message('success','Tipo de pagamento editado com sucesso!');
            $this->redirect_to('/pagamentos-tipos');
        }else{
            Flash::message('danger','O formulário contém erros!');
        }
        $this->view = 'payment_types/edit';
    }

    public function destroy(){
        $type = PaymentType::find( $this->params[':id'] );
        if( $type->destroy() ){
            Flash::message('success','Tipo de pagamento excluido com sucesso!');
        }else{
            Flash::message('danger','Erro ao excluir o motivo!');
        }
        $this->redirect_to('/pagamentos-tipos');
    }

    public function show(){
        $this->type = PaymentType::find($this->params[':id']);
    }

    public function edit(){
        $this->type = PaymentType::find($this->params[':id']);
    }

}