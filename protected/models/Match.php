<?php
class Match extends CActiveRecord
{
	public $id;
	public $teamA_id;
	public $teamB_id;
	public $time_match;
	public $league_id;
	public $HT;
	public $FT;
	public $status;
	public $minute;
	public $current_period;
	public $other;
	
	public static function model($className = __CLASS__)
	{
		return parent::model(__CLASS__);
	}
	
	public function tableName()
	{
		return "matchFootball";
	}
	
}