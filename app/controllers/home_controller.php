<?php class HomeController extends ApplicationController
{

    public function index()
    {
        $this->slide_rooms = RoomPhoto::getBestRooms();
        $this->most_reserved = RoomPhoto::getMostReserved();
    }


    public function about(){

    }


}

?>
