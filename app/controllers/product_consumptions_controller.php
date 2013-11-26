<?php

class ProductConsumptionsController extends ApplicationController
{

    public function beforeAction($action)
    {
        $roles = [
            'index' => 1,
            'history' => 1,
            'show' => 1,
            'fresh' => 1,
            'create' => 1,
            'destroy' => 2
        ];
        parent::beforeAction($action, $roles);
        $this->countAccommodations = Accommodation::countActiveAccommodations();
        $this->month = '01'.date('/m/Y');
        $this->date = date('d/m/Y');
    }

    public function index()
    {
        $this->consumptions = ProductConsumption::last();
    }

    public function history(){
        $this->consumptions= false;
        $this->search = new Field('search');
        $this->date1 = new Field('date1',$this->month);
        $this->date2 = new Field('date2', $this->date);
        if( isset( $this->params['search'] ) ){
            $searching = $this->params['search'];
            $this->search->setValue($searching);
            $this->date1->setValue($this->params['date1']);
            $this->date2->setValue($this->params['date2']);
            $this->consumptions = ProductConsumption::like($searching,$this->date1->getValue(),
                $this->date2->getValue());
        }
    }

    public function fresh()
    {
        $this->accommodation = Accommodation::find($this->params[':id']);
        $this->consumption = new ProductConsumption();
        $this->products = Product::forSelect();
    }

    public function create()
    {
        $this->accommodation = Accommodation::find($this->params[':id']);
        $this->products = Product::forSelect();
        $this->consumption = new ProductConsumption($this->params['consumption']);
        if ($this->consumption->save()) {
            Flash::message('success', 'Consumo gerado com sucesso!');
            $this->redirect_to('/produtos-consumos');
        } else {
            Flash::message('danger', 'Não foi possível gerar o consumo! Verifique o formulário!');
        }
        $this->view = 'product_consumptions/fresh';
    }


    public function show()
    {
        $this->product_consumption = ProductConsumption::findBelongs($this->params[':id'], [
            'belongs' => [
                ['table' => 'products', 'through' => 'product_id'],
                ['table' => 'accommodations', 'through' => 'accommodation_id'],
            ]
        ]);
    }


    public function destroy()
    {
        $this->consumption = ProductConsumption::find($this->params[':id']);
        if ($this->consumption->destroy()) {
            Flash::message('success', 'Consumo de produto cancelado com sucesso!');
        } else {
            Flash::message('danger', 'Não foi possível cancelar o consumo!');
        }
        $this->redirect_to( '/produtos-consumos' );
    }


}