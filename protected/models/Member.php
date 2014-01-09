<?php
class Member extends CActiveRecord
{
	public $id;
	public $name;
	public $email;
	public $password;
	public $other;
	
	public static function model($className = __CLASS__)
	{
		return parent::model(__CLASS__);
	}
	
	public function tableName()
	{
		return "member";
	}
	
}