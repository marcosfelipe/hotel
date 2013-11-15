<?php class ApplicationController extends BaseController
{
    private $currentUser;

    public function currentUser()
    {
        if( isset($_SESSION['user']['id']) ){
            if ($this->currentUser == null) {
                $this->currentUser = User::findById($_SESSION['user']['id']);
            }
            return $this->currentUser;
        }
        return null;
    }
}
