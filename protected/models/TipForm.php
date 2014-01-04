<?php

class TipForm extends CFormModel
{
	public $tip;
	public $odds;
	public $tip_who_id;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('tip, odds, tip_who_id', 'required'),
		);
	}
}
