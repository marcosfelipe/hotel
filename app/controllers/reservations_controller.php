<?php

require 'vendor/utils.php';

class ReservationsController extends ApplicationController
{

    public function beforeAction($action){
        $roles = [
            'all' => 1,
        ];
        parent::beforeAction($action,$roles);
        $this->accounting = Reservation::countActiveReservations();
    }

    public function index()
    {
        $this->guests = Accommodation::countActiveAccommodations();
        $this->reservations = Reservation::activeReservations();
    }

    public function fresh()
    {
        $this->reasons = Reason::forSelect();
        $this->clients = Client::forSelect();
        $this->rooms = Reservation::roomsForSelect();
        $this->reservation = new Reservation();
        $this->agora = date('d/m/Y H:i:s');
    }

    public function create()
    {
        $this->agora = date('d/m/Y H:i:s');
        $this->reasons = Reason::forSelect();
        $this->clients = Client::forSelect();
        $this->rooms = Reservation::roomsForSelect();
        $this->reservation = new Reservation( $this->params['reservation']+['active' => 'true'] );
        if ($this->reservation->save()) {
            Flash::message('success', 'Reserva criada com sucesso!');
            $this->redirect_to('/reservas');
        } else {
            Flash::message('danger', 'Não foi possível criar a reserva! Verifique o formulário!');
        }
        $this->view = 'reservations/fresh';
    }


    public function checkIn()
    {
        $accommodation = new Accommodation();
        $accommodation->setData([ 'reservation_id' => $this->params[':id'],
            'check_in' => date('Y-m-d H:i:s'),
            'control' => '20'.Utils::clear_str(microtime(true)) ]);
        if ($accommodation->save()) {
            Flash::message('success', 'Check-in efetuado com sucesso!
                A reserva foi movida para lista de hóspedes.');
        } else {
            Flash::message('danger', 'Erro ao efetuar o check-in!');
        }
        $this->redirect_to( $this->back() );
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
        $this->redirect_to( $this->back() );
    }

    public function show()
    {
        $this->reservation = Reservation::findBelongs($this->params[':id'],[
            'belongs' => [
                ['table' => 'reasons', 'through' => 'reason_id'],
                ['table' => 'clients', 'through' => 'client_id'],
                ['table' => 'rooms', 'through' => 'room_id'],
                ['table' => 'employees', 'through' => 'employee_id'],
            ]
        ]);
    }


}