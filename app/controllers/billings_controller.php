<?php

class BillingsController extends ApplicationController
{

    public function beforeAction($action)
    {
        $roles = [
            'all' => 2,
        ];
        parent::beforeAction($action, $roles);
        $this->now = date('d/m/Y H:i:s');
        $this->date = date('d/m/Y');
    }

    public function index()
    {
        $this->todayBilling = Billing::todayBilling();
    }

    public function search()
    {
        $this->billing = false;
        $this->date1 = new Field('date1');
        $this->date2 = new Field('date2');
        if( isset( $this->params['date1'] ) ){
            $date1 = $this->params['date1'];
            $date2 = $this->params['date2'];
            $this->date1->setValue($date1);
            $this->date2->setValue($date2);
            $this->billing = Billing::periodicBilling($date1, $date2);
        }else{
            $this->date1->setValue('01/'.date('m/Y'));
            $this->date2->setValue($this->date);
        }
    }

    public function generate(){
        header("Content-type: text/html; charset=iso-8859-1");
        $html = $this->params['html'];
        $this->file = Billing::toPdf($html);
        $this->response_type = 'json';

    }


}