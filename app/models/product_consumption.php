<?php

class ProductConsumption extends Base{

    protected $fields = [
        'product_id',
        'accommodation_id',
        'note',
        'price' => ['type' => 'float'],
        'amount',
        'created_at'
    ];

}