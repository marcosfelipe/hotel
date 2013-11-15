<?php

class ProductsController extends ApplicationController
{

    public function index()
    {
        static $products;
        $products = Product::joins('LEFT JOIN product_types ON products.product_type_id = product_types.id',
            ['fields' => 'products.id as product_id,
                products.description as product_description, products.price as product_price,
                product_types.description as product_type_description,
                product_types.id as product_type_id']);
    }

    public function fresh()
    {
        static $product, $types;
        $product = new Product();
        $types = ProductType::allS(array('fields' => 'id as value,description as option'));
    }

    public function create()
    {
        static $types, $product;
        $types = ProductType::allS(['fields' => 'id as value,description as option']);
        $product = new Product($this->params['product']);
        if ($product->save()) {
            Flash::message('success', 'Novo tipo criado com sucesso!');
            $this->redirect_to('/produtos');
        } else {
            Flash::message('danger', 'O formulário contém erros!');
        }
        $this->view = 'products/fresh';
    }

    public function update()
    {
        static $types, $product;
        $types = ProductType::allS(['fields' => 'id as value,description as option']);
        $product = Product::find($this->params[':id']);
        $product->setData($this->params['product']);

        if ($product->update()) {
            Flash::message('success', 'Tipo editado com sucesso!');
            $this->redirect_to('/produtos');
        } else {
            Flash::message('danger', 'O formulário contém erros!');
        }
        $this->view = 'products/edit';
    }

    public function destroy()
    {
        $product = Product::find($this->params[':id']);
        if ($product->destroy()) {
            Flash::message('success', 'Tipo excluido com sucesso!');
        } else {
            Flash::message('danger', 'Erro ao excluir o motivo!');
        }
        $this->redirect_to('/produtos');
    }

    public function show()
    {
        static $product;
        $product = Product::findBelongs($this->params[':id'],
            ['belongs' => [
                    ['table' => 'product_types', 'through' => 'product_type_id']
                ]
            ]
        );
    }

    public function edit()
    {
        static $product, $types;
        $types = ProductType::allS(['fields' => 'id as value,description as option']);
        $product = Product::find($this->params[':id']);
    }

}