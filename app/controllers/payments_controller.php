<?php

class PaymentsController extends ApplicationController
{

    public function beforeAction($action)
    {
        $roles = [
            'index' => 1,
            'show' => 1,
            'fresh' => 1,
            'create' => 1,
            'destroy' => 2
        ];
        parent::beforeAction($action, $roles);
    }

    public function index()
    {
        $this->countAccommodations = Accommodation::countActiveAccommodations();
        $this->payments = Payment::last();
    }

    public function history()
    {
        $this->payments = false;
        $this->search = new Field('search');
        if( isset( $this->params['search'] ) ){
            $searching = $this->params['search'];
            $this->search->setValue($searching);
            $this->payments = Payment::like($searching);
        }
    }

    public function fresh()
    {
        $this->accommodation = Accommodation::find($this->params[':id']);
        $this->payment = new Payment();
        $this->types = PaymentType::forSelect();
    }

    public function create()
    {
        $this->accommodation = Accommodation::find($this->params[':id']);
        $this->types = PaymentType::forSelect();
        $this->payment = new Payment($this->params['payment']);
        if ($this->payment->save()) {
            Flash::message('success', 'Pagamento efetuado com sucesso!');
            $this->redirect_to('/pagamentos');
        } else {
            Flash::message('danger', 'Não foi possível efetuar o pagamento! Verifique o formulário!');
        }
        $this->view = 'payments/fresh';
    }


    public function show()
    {
        $this->payment = Payment::findBelongs($this->params[':id'], [
            'belongs' => [
                ['table' => 'payment_types', 'through' => 'payment_type_id'],
                ['table' => 'accommodations', 'through' => 'accommodation_id'],
            ]
        ]);
    }


    public function destroy()
    {
        $this->payment = Payment::find($this->params[':id']);
        if ($this->payment->destroy()) {
            Flash::message('success', 'Pagamento cancelado com sucesso!');
        } else {
            Flash::message('danger', 'Não foi possível cancelar o pagamento!');
        }
        $this->redirect_to( '/pagamentos' );
    }


}