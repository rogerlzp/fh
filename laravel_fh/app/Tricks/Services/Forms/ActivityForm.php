<?php

namespace Tricks\Services\Forms;

class ActivityForm extends AbstractForm
{
    /**
     * The validation rules to validate the input data against.
     *
     * @var array
     */
    protected $rules = [
        'title'         => 'required|min:4|unique:activity,title',
        'description'   => 'required|min:10',
        'topic'          => 'required'
    ];

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'title', 'description', 'topic'
        ]);
    }
}
