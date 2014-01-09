<?php

class AskForm extends CFormModel
{
	public $title;
	public $content;
	public $tags;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('title, content, tags', 'required'),
		);
	}
}
