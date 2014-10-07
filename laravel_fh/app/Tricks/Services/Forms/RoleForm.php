<?php

namespace Tricks\Services\Forms;

class RoleForm extends AbstractForm
{
    /**
     * The validation rules to validate the input data against.
     *
     * @var array
     */
    protected $rules = [
        'name'        => 'required'
    ];
}
