<?php
class League extends CActiveRecord
{
	public $id;
	public $name;
	public $country;
	public $other;
	
	public static function model($className = __CLASS__)
	{
		return parent::model(__CLASS__);
	}
	
	public function tableName()
	{
		return "league";
	}
	
}