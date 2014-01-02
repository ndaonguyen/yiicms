<?php
class Team extends CActiveRecord
{
	public $id;
	public $name;
	public $flag;
	public $country;
	public $point;
	public $game_played;
	public $won;
	public $drawn;
	public $lost;
	public $goals_forward;
	public $goals_against;
	public $goals_diff;
	public $other;
	
	public static function model($className = __CLASS__)
	{
		return parent::model(__CLASS__);
	}
	
	public function tableName()
	{
		return "team";
	}
	
}