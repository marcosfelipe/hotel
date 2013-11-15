<?php

class ContactsController extends ApplicationController{

    public function create(){
        $this->contact = new Contact( $this->params['contact']);
        if( $this->contact->save() ){
            Flash::message("success",'Mensagem enviada! Obrigado pela participação!');
            $this->redirect_to('/fale-conosco');
        }else{
            Flash::message("danger", 'Erro no formulario!');
        }
        $this->view = 'contacts/fresh';
    }

    public function fresh(){
        $this->contact = new Contact();
    }


}