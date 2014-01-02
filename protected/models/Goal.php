<?php
class Goal extends CActiveRecord
{
	public $id;
	public $match_id;
	public $type;
	public $team;
	public $minute;
	public $name;
	public $other;
	
	public static function model($className = __CLASS__)
	{
		return parent::model(__CLASS__);
	}
	
	public function tableName()
	{
		return "goal";
	}
	
}