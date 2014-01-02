<?php
class Favourite extends CActiveRecord
{
	public $member_id;
	public $match_id;
	
	public static function model($className = __CLASS__)
	{
		return parent::model(__CLASS__);
	}
	
	public function tableName()
	{
		return "favourite";
	}
	
}