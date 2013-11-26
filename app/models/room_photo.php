<?php


class RoomPhoto extends Base
{

    protected $fields = array(
        'name',
        'type',
        'size',
        'room_id',
        'created_at'
    );

    public $tmp_name;
    public $path;
    public $error;

    public function __construct($data = array())
    {
        $this->tmp_name = new Field('tmp_name');
        $this->error = new Field('error');
        $this->path = APP_ROOT_FOLDER . "/app/assets/photos/";
        parent::__construct($data);
    }

    public function savePhoto()
    {
        $this->generateName();
        return $this->save() && $this->saveToDisc();
    }


    public function deletePhoto()
    {
        return $this->deleteFromDisc() && $this->destroy();
    }

    private function generateName()
    {
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $this->name->getValue(), $ext);
        if ($ext)
            $this->name->setValue( md5(uniqid(time())) . '.' . $ext[1]);
    }

    private function saveToDisc()
    {
        // move a imagem para a pasta correta
        $original = $this->path . "original/" . $this->name->getValue();
        $thumb = $this->path . "thumb/" . $this->name->getValue();
        if( move_uploaded_file($this->tmp_name->getValue(), $original) ){
            require_once 'wide-image/WideImage.php';
            WideImage::load($original)->resize(125, 125, 'fill')->saveToFile($thumb);
            return true;
        }
        return false;
    }

    private function deleteFromDisc()
    {
        $original = $this->path . "original/" . $this->name->getValue();
        $thumb = $this->path . "thumb/" . $this->name->getValue();
        return unlink($original) && unlink($thumb);
    }

    /* para slide show */
    public static function getBestRooms(){

        $rooms = Room::joins('
            INNER JOIN room_photos ON room_photos.room_id = rooms.id
            ORDER BY room_id, rooms.price DESC
            LIMIT 3
        ',['fields' => 'distinct on (room_id) room_id, name, rooms.price,
            rooms.description as room_description,
            rooms.number as room_number
        ']);
        return $rooms;
    }

    /* os mais reservados */
    public static function getMostReserved(){
        $rooms = Reservation::joins('
            INNER JOIN rooms ON rooms.id = reservations.room_id
            LEFT JOIN room_photos ON reservations.room_id = room_photos.room_id
            GROUP BY reservations.room_id, rooms.number, room_photos.name, rooms.description
            ORDER BY reservations.room_id, count DESC
            LIMIT 3
        ',['fields' => '
            distinct on (reservations.room_id) reservations.room_id,
            rooms.number, room_photos.name, rooms.description, count(*)
        ']);
        return $rooms;
    }

}

?>
