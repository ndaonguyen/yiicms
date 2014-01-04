<?php
class Tip_who extends CActiveRecord
{
	public $id;
	public $name;
	public $description;
	public $other;
	
	public static function model($className = __CLASS__)
	{
		return parent::model(__CLASS__);
	}
	
	public function tableName()
	{
		return "tip_who";
	}
	
}