<?php

namespace Tricks\Services\Forms;

class ProductForm extends AbstractForm
{
    /**
     * The validation rules to validate the input data against.
     *
     * @var array
     */
	/*
    protected $rules = [
        'name'         => 'required|min:4',
        'short_description'   => 'required|min:10',
        'sku'   => 'required|min:6',
        'stock'  => 'required',
        '_token'  => 'required'
    ];*/

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    
    public function getInputData()
    {
        return array_only($this->inputData, [
            'name', 'short_description', 'sku', 'stock'
        ]);
    } 
}
