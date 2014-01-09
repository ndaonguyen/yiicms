<?php
class Vote_result extends CActiveRecord
{
	public $member_id;
	public $match_id;
	public $vote_result;
	
	public static function model($className = __CLASS__)
	{
		return parent::model(__CLASS__);
	}
	
	public function tableName()
	{
		return "voteResult";
	}
	
}