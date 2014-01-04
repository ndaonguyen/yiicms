<?php

class TipuserForm extends CFormModel
{
	public $name;
	public $description;
	public $other;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('name, description', 'required'),
		);
	}
}
