<?php
class Tip extends CActiveRecord
{
	public $id;
	public $match_id;
	public $tip;
	public $odds;
	public $tip_who_id;
	
	public static function model($className = __CLASS__)
	{
		return parent::model(__CLASS__);
	}
	
	public function tableName()
	{
		return "tip";
	}
	
}