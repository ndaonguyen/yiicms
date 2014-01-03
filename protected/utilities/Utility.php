<?php
require_once($path = Yii::app()->basePath."/models/Country.php");
require_once($path = Yii::app()->basePath."/models/Member.php");
require_once($path = Yii::app()->basePath."/models/Team.php");
require_once($path = Yii::app()->basePath."/models/Goal.php");
require_once($path = Yii::app()->basePath."/models/League.php");
require_once($path = Yii::app()->basePath."/models/Tip.php");
require_once($path = Yii::app()->basePath."/models/Tip_who.php");
require_once($path = Yii::app()->basePath."/models/Favourite.php");
require_once($path = Yii::app()->basePath."/models/Vote_result.php");
//Yii::import("$path = Yii::app()->basePath.models.*");


class Utility
{
	
	public static function getDaysLiveURL($numDayBeforeToday, $numDayAfterToday)
	{
		$PARENT_URL	      = "http://xml.tbwsport.com/SportccFixtures.aspx";
		$DATA_USER_ID	  = "266";
		$DATA_PWD	      = "123digital321"; 
	/*	
		$now          = date("m/d/Y");
		$daybeforeNow = date('m/d/Y', strtotime($now. ' - ' +$numDayBeforeToday + 'days'));
		$dayAfterNow  = date('m/d/Y', strtotime($now. ' + ' +$numDayAfterToday  + 'days'));
	*/

		$daybeforeNow = date('m/d/Y', strtotime("-".$numDayBeforeToday." days"));
		$dayAfterNow = date('m/d/Y', strtotime("+".$numDayAfterToday." days"));
		
		$daysUrl      = $PARENT_URL. "?sport_id=1&userID=" .$DATA_USER_ID. "&fromDate=" .$daybeforeNow
		                ."&toDate=" .$dayAfterNow. "&pass=" . $DATA_PWD ;
		
		return $daysUrl;
	}
	/*
	public static function getDaysLiveURL(int numDayBeForeToday, int numDayAfterToday)
	{
		Calendar now = Calendar.getInstance();
		SimpleDateFormat formatter = new SimpleDateFormat("MM/dd/yyyy"); 
		now.add(Calendar.DATE, - numDayBeForeToday);
	    String daysBeforeNow = formatter.format(now.getTime());
	    
	    now = Calendar.getInstance();
	    now.add(Calendar.DATE, numDayAfterToday);
	    String daysAfterNow = formatter.format(now.getTime());
	    
	    String daysUrl = CONFIG.PARENT_URL + "?sport_id=1&userID="+ CONFIG.DATA_USER_ID +"&fromDate=" + daysBeforeNow 
	    		         + "&toDate=" + daysAfterNow+ "&pass="+ CONFIG.DATA_PWD;
	    
	    return daysUrl;
	}
	*/
	
	public static function saveDaysRecordDb($daysUrl)
	{
		$dom = new domDocument;
		@$dom->load($daysUrl);
		
		$cas = $dom->getElementsByTagName("Category");
		
		foreach( $cas as $category )
		{
			$idCountry     = $category->attributes->getNamedItem('id')->value;
			if(Country::model()->findByPk($idCountry)==Null)
			{
				$countryItem   = new Country;
				$countryItem->id   = $idCountry;
				$countryItem->name = $category->attributes->getNamedItem('name')->value;
				$countryItem->save();
			}
			
			if (!$category->hasChildNodes())
				continue;
				
			$childCats = $category->childNodes;
			foreach ($childCats as $childCat) // Tournament
			{
				$val  = $childCat->nodeName;
				if($childCat->nodeName != "Tournament")
					continue;
				
				$idLeague     = $childCat->attributes->getNamedItem('id')->value;
				if(League::model()->findByPk($idLeague) == Null)
				{
					$leagueItem  = new League;
					$leagueItem->id      = $idLeague;
					$leagueItem->name    = $childCat->attributes->getNamedItem('name')->value;
					$leagueItem->country = $idCountry;
					$leagueItem->save();
				}
				
				if (!$childCat->hasChildNodes())
					continue;
				
				$leagueChilds = $childCat->childNodes; 
				foreach($leagueChilds as $leagueChild) // Match
				{
					if($leagueChild->nodeName != "Match")
						continue;
						
					$idMatch       = $leagueChild->attributes->getNamedItem('id')->value;
					if(MatchFootball::model()->findByPk($idMatch) == Null)
					{
						$match  = new MatchFootball;
						$match->id             = $idMatch;
						$match->status         = $leagueChild->attributes->getNamedItem('status')->value;
						$match->time_match     = $leagueChild->attributes->getNamedItem('date')->value;
						$match->current_period = $leagueChild->attributes->getNamedItem('CurentPeriod')->value;
						$match->minute         = $leagueChild->attributes->getNamedItem('minutes')->value;
						$match->league_id      = $idLeague;
						
						if (!$leagueChild->hasChildNodes())
							continue;
						
						$matchChilds = $leagueChild->childNodes;
						foreach ($matchChilds as $matchChild) // competitors and result
						{
							if($matchChild->nodeName != "Competitors" && $matchChild->nodeName != "Result")
								continue;
							
							if($matchChild->nodeName == "Competitors")
							{
								if (!$matchChild->hasChildNodes())
									continue;
								
								$competitorsChilds = $matchChild->childNodes;
								foreach ($competitorsChilds as $competitor)
								{
									if($competitor->nodeName != "Competitor")
										continue;
									
									$idTeam   = $competitor->attributes->getNamedItem('ID')->value;
									if(Team::model()->findByPk($idTeam) == Null)
									{
										$team       = new Team;
										$team->id   = $idTeam;
										$team->name = $competitor->attributes->getNamedItem('name')->value;
										$team->save();
									}
									$orderTeam   = $competitor->attributes->getNamedItem('type')->value;
									if($orderTeam == "1")
										$match->teamA_id = $idTeam;
									else
										$match->teamB_id = $idTeam;
								}
							}
							else
							{
								if (!$matchChild->hasChildNodes())
									continue;
								
								$scoreChilds = $matchChild->childNodes;
								foreach ($scoreChilds as $scoreInfo) // ScoreInfo
								{
									if($scoreInfo->nodeName != "ScoreInfo")
										continue;
									
									if (!$scoreInfo->hasChildNodes())
										continue;
									
									$scoreInfoChilds  = $scoreInfo->childNodes;
									foreach ($scoreInfoChilds as $scoreInfoChild) // Score or comment
									{
										if($scoreInfoChild->nodeName != "Score"  && $scoreInfoChild->nodeName != "comment")
											continue;
										
										if($scoreInfoChild->nodeName == "Score")
										{
											$scoreType = $scoreInfoChild->attributes->getNamedItem('Type')->value;
											$valueType = $scoreInfoChild->attributes->getNamedItem('name')->value;
											if($scoreType == "HT")
												$match->HT = $valueType;
											else
												$match->FT = $valueType;
										}
										else
										{
											if (!$scoreInfoChild->hasChildNodes())
												continue;
											
											$commentChilds = $scoreInfoChild->childNodes; // goals and cards
											foreach ($commentChilds as $goals)
											{
												if($goals->nodeName != "Goals")
													continue;
												
												if (!$goals->hasChildNodes())
													continue;
											
												$goalsChilds = $goals->childNodes; 
												foreach ($goalsChilds as $goal)
												{
													$idGoal = $goal->attributes->getNamedItem('goalid')->value;
													if(Goal::model()->findByPk($idGoal) == Null)
													{
														$goalItem           = new Goal;
														$goalItem->id       = $idGoal;
														$goalItem->type     = $goal->attributes->getNamedItem('type')->value;
														$goalItem->match_id = $idMatch;
														$goalItem->team     = $goal->attributes->getNamedItem('team')->value;
														$goalItem->minute   = $goal->attributes->getNamedItem('minute')->value;
														$goalItem->name     = $goal->attributes->getNamedItem('name')->value;
														
														$goalItem->save();
													}
												}
											}
										}	
									}
								}								
							}
						}
						// add match
						$match->save();
					}
				}
			}
		}
	}
	
	
	
	
	
}