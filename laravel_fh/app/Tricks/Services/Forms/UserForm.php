<?php

namespace Tricks\Services\Forms;

class UserForm extends AbstractForm
{
    /**
     * The validation rules to validate the input data against.
     *
     * @var array
     */

	
	/**
	 * Get the prepared input data.
	 *
	 * @return array
	 */
	public function getInputData()
	{
		return array_only($this->inputData, [
				'mobile', 'email', 'username', 'company', 'department','title','address','phone','roles'
				]);
	}
}
