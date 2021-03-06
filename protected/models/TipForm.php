<?php

class TipForm extends CFormModel
{
	public $tip;
	public $tipOther;
	public $odds;
	public $tip_who_id;
	
	public $match_id;
	public $tip_id;
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
			array('odds', 'numerical',
				  'integerOnly'=>true,
			      'min'=>1,
			      'max'=>50),
			array('tipOther, match_id, tip_id', 'safe')
		);
	}
}
