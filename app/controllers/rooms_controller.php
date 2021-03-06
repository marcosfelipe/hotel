<?php

class RoomsController extends ApplicationController
{

    public function beforeAction($action)
    {
        $roles = [
            'index' => 1,
            'fresh' => 1,
            'create' => 1,
            'edit' => 1,
            'update' => 1,
            'destroy' => 1,
            'show' => 1,
            'verify' => 1,
        ];
        parent::beforeAction($action, $roles);
    }

    public function index()
    {
        $this->reservations = Reservation::countActiveReservations();
        $this->rooms = Room::joins('
            LEFT JOIN room_types ON rooms.room_type_id = room_types.id
            LEFT JOIN reservations ON reservations.room_id = rooms.id AND reservations.active = true
            WHERE rooms.active = true',
            ['fields' => 'rooms.id as room_id,
                rooms.number as room_number, rooms.floor as room_floor,
                rooms.description as room_description,
                rooms.price as room_price,
                room_types.title as room_type_title,
                room_types.id as room_type_id,
                reservations.id as reservation_id
                ']);
    }

    public function fresh()
    {
        $this->room = new Room();
        $this->types = RoomType::allS(['fields' => 'id as value,title as option']);
    }

    public function create()
    {
        $this->types = RoomType::allS(['fields' => 'id as value,description as option']);
        $this->room = new Room($this->params['room']);
        if ($this->room->save()) {
            Flash::message('success', 'Nova acomodação criada com sucesso!');
            $this->redirect_to('/acomodacoes');
        } else {
            Flash::message('danger', 'O formulário contém erros!');
        }
        $this->view = 'rooms/fresh';
    }

    public function update()
    {
        $this->types = RoomType::allS(['fields' => 'id as value,description as option']);
        $this->room = Room::find($this->params[':id']);
        $this->room->setData($this->params['room']);
        if ($this->room->update()) {
            Flash::message('success', 'Acomodação editada com sucesso!');
            $this->redirect_to('/acomodacoes');
        } else {
            Flash::message('danger', 'O formulário contém erros!');
        }
        $this->view = 'rooms/edit';
    }

    public function destroy()
    {
        $room = Room::find($this->params[':id']);
        if ($room->destroy()) {
            Flash::message('success', 'Tipo excluido com sucesso!');
        } else {
            Flash::message('danger', 'Erro ao excluir o motivo!');
        }
        $this->redirect_to('/acomodacoes');
    }

    public function show()
    {
        $this->photos = RoomPhoto::where("room_id = '{$this->params[':id']}' ");
        $this->room = Room::findBelongs($this->params[':id'],
            ['belongs' => [
                ['table' => 'room_types', 'through' => 'room_type_id']
            ]
            ]
        );
    }

    public function details()
    {
        $this->show();
    }

    public function listing()
    {
        $this->index();
    }

    public function edit()
    {
        $this->types = RoomType::allS(['fields' => 'id as value,title as option']);
        $this->room = Room::find($this->params[':id']);
    }

    public function verify()
    {
        $room = Room::find($this->params[':id']);
        $this->result = $room->hasReservation();
        $this->response_type = 'json';
    }

}