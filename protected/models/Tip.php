<?php
class Tip extends CActiveRecord
{
	public $id;
	public $match_id;
	public $tip_id;
	public $odds;
	public $who;
	
	public static function model($className = __CLASS__)
	{
		return parent::model(__CLASS__);
	}
	
	public function tableName()
	{
		return "tip";
	}
	
}