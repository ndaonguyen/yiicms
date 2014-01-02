<?php
class Country extends CActiveRecord
{
	public $id;
	public $name;
	public $other;
	
	public static function model($className = __CLASS__)
	{
		return parent::model(__CLASS__);
	}
	
	public function tableName()
	{
		return "country";
	}
	
}