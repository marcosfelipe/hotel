<?php

class RoomPhotosController extends ApplicationController
{

    public function create()
    {

        $photo = new RoomPhoto($_FILES['photo']);
        $photo->setData(['room_id' => $this->params[':id']]);
        if ($photo->savePhoto()) {
            Flash::message('success', 'Foto adicionada com sucesso!');
        } else {
            Flash::message('danger', 'Falha no upload do arquivo! Verifique o arquivo de imagem!');
        }
        $this->redirect_to( $this->back() );
    }

    public function destroy()
    {
        $photo = RoomPhoto::find($this->params[':id']);
        if( $photo->deletePhoto() )
            Flash::message('success', 'Imagem removida com sucesso!');
        else
            Flash::message('danger', 'Erro ao excluír a foto!');
        $this->redirect_to($this->back());
    }
}

?>
