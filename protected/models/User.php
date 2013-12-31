<?php

class User extends CActiveRecord
{
	
	public $id;
	public $name;
	public $email;
	public $phone;
	public $pwd;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}