<?php
class Tag extends CActiveRecord
{
	public $id;
	public $name;
	public $description;
	
	public static function model($className = __CLASS__)
	{
		return parent::model(__CLASS__);
	}
	
	public function tableName()
	{
		return "qa_tag";
	}
	
}