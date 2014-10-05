<?php namespace Tricks\Services\Forms;

class BoardForm extends AbstractForm {
	
	protected $rules = [
	'board_name'        => 'required'
	];
}
