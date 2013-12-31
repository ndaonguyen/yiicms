<?php
class QuestionTag extends CActiveRecord
{
	public $question_id;
	public $tag_id;
	
	public static function model($classname = __CLASS__)
	{
		return parent::model(__CLASS__);
	}
	
	public function tableName()
	{
		return "qa_question_tag";
	}
	
}