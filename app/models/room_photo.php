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

}

?>
