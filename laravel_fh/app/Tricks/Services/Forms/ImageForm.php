<?php namespace Tricks\Services\Forms;

class ImageForm extends AbstractForm {
	
	protected $rules = [
	'image_name'        => 'required',
	'description'       => 'required|min:4',
	'image_path'        => 'required'
//	'boards'          => 'required'
	];
}
