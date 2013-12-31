<?php
class Question extends CActiveRecord
{
	public $id;
	public $title;
	public $content;
	
	public static function model($className=__CLASS__)
	{
		return parent::model(__CLASS__);
	}
	
	public function tableName()  // this is for getting which table to get
	{
		return 'qa_question';
	}
}