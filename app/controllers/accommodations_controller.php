<?php

class AccommodationsController extends ApplicationController
{

    public function beforeAction($action)
    {
        $roles = [
            'all' => '1',
        ];
        parent::beforeAction($action, $roles);
        $this->accounting = Accommodation::countActiveAccommodations();
        $this->agora = date('d/m/Y H:i:s');
    }

    public function index()
    {
        $this->reservations = Reservation::countActiveReservations();
        $this->accommodations = Accommodation::activeAccommodations();
    }

    public function fresh()
    {
        $this->reasons = Reason::forSelect();
        $this->clients = Client::forSelect();
        $this->rooms = Reservation::roomsForSelect();
        $this->reservation = new Reservation();
    }

    public function create()
    {
        $this->agora = date('d/m/Y H:i:s');
        $this->reasons = Reason::forSelect();
        $this->clients = Client::forSelect();
        $this->rooms = Reservation::roomsForSelect();
        $this->reservation = new Reservation($this->params['reservation'] + ['active' => 'true']);
        if ($this->reservation->save()) {
            Flash::message('success', 'Reserva criada com sucesso!');
            $this->redirect_to('/reservas');
        } else {
            Flash::message('danger', 'Não foi possível criar a reserva! Verifique o formulário!');
        }
        $this->view = 'reservations/fresh';
    }


    public function checkOut()
    {
        //checkout hospedagem
        $accommodation = Accommodation::find($this->params[':id']);
        $accommodation->setData(['check_out' => date('Y-m-d H:i:s')]);
        //set false para active na reserva
        $reservation = Reservation::find($accommodation->reservation_id->getValue());
        $reservation->setData(['active' => 'false']);
        if ($accommodation->hasPayment()) {
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
        $this->accommodation->totalDebt();

    }


}