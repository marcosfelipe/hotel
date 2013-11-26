<?php

class AccommodationsController extends ApplicationController
{

    public function beforeAction($action)
    {
        $roles = [
            'all' => 1,
        ];
        parent::beforeAction($action, $roles);
        $this->accounting = Accommodation::countActiveAccommodations();
        $this->now = date('d/m/Y H:i:s');
        $this->month = '01'.date('/m/Y');
        $this->date = date('d/m/Y');
    }

    public function index()
    {
        $this->reservations = Reservation::countActiveReservations();
        $this->accommodations = Accommodation::activeAccommodations();
    }

    public function history()
    {
        $this->countAccommodations = Accommodation::countActiveAccommodations();
        $this->accommodations = false;
        $this->search = new Field('search');
        $this->date1 = new Field('date1',$this->month);
        $this->date2 = new Field('date2', $this->date);
        if( isset( $this->params['search'] ) ){
            $this->search->setValue($this->params['search']);
            $this->date1->setValue($this->params['date1']);
            $this->date2->setValue($this->params['date2']);
            $this->accommodations = Accommodation::like($this->search->getValue(),
                $this->date1->getValue(), $this->date2->getValue()
            );
        }
    }

    public function checkOut()
    {
        //checkout hospedagem
        $accommodation = Accommodation::find($this->params[':id']);
        $has_check_out = $accommodation->check_out->getValue();
        if( !empty($has_check_out) ){
            Flash::message('danger','Esta hospedagem já possui check-out!');
            $this->redirect_to($this->back());
        }elseif ($accommodation->hasPayment()) {
            $accommodation->setData(['check_out' => date('Y-m-d H:i:s')]);
            //set false para active na reserva
            $reservation = Reservation::find($accommodation->reservation_id->getValue());
            $reservation->setData(['active' => 'false']);
            if ($accommodation->update() && $reservation->update()) {
                Flash::message('success', 'Check-out efetuado com sucesso!
                    A hospedagem foi movida para o histórico.');
            } else {
                Flash::message('danger', 'Erro ao efetuar o check-out!');
            }
        } else
            Flash::message('danger', 'Hospedagem pendente de pagamento!');
        $this->redirect_to('/hospedagens');
    }

    public function cancel()
    {
        $reservation = Reservation::find($this->params[':id']);
        $reservation->setData(['active' => 'false']);
        if ($reservation->update()) {
            Flash::message('success', 'Reserva cancelada com sucesso!');
        } else {
            Flash::message('danger', 'Erro ao cancelar a reserva!');
        }
        $this->redirect_to($this->back());
    }

    public function show()
    {
        $this->accommodation = Accommodation::find($this->params[':id']);
        $this->reservation = Reservation::findBelongs($this->accommodation->reservation_id->getValue(), [
            'belongs' => [
                ['table' => 'reasons', 'through' => 'reason_id'],
                ['table' => 'clients', 'through' => 'client_id'],
                ['table' => 'rooms', 'through' => 'room_id'],
                ['table' => 'employees', 'through' => 'employee_id'],
            ]
        ]);
    }

    public function payment()
    {
        $acc_id = $this->params[':id'];
        $this->accommodation = Accommodation::find($acc_id);
        $this->reservation = Reservation::findBelongs($this->accommodation->reservation_id->getValue(), [
            'belongs' => [
                ['table' => 'reasons', 'through' => 'reason_id'],
                ['table' => 'clients', 'through' => 'client_id'],
                ['table' => 'rooms', 'through' => 'room_id'],
                ['table' => 'employees', 'through' => 'employee_id'],
            ]
        ]);
        $this->services = $this->accommodation->services();
        $this->products = $this->accommodation->productConsumptions();
        $this->payments = $this->accommodation->payments();
        $this->total = $this->accommodation->totalDebt();

    }



}