<?php
require_once($path = Yii::app()->basePath."/models/Country.php");
require_once($path = Yii::app()->basePath."/models/Member.php");
//Yii::import("$path = Yii::app()->basePath.models.*");


class Utility
{
	public static function saveDaysRecordDb($daysUrl)
	{
		$daysUrl = "http://xml.tbwsport.com/SportccFixtures.aspx?sport_id=1&userID=266&fromDate=12/22/2013&toDate=12/31/2013&pass=123digital321";
		$dom = new domDocument;
		@$dom->load($daysUrl);
	//	echo $dom->saveXML();
		
		
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
			
			if ($category->hasChildNodes())
			{
				$childs = $category->childNodes;
				foreach ($childs as $childCat)
				{
					$val  = $childCat->nodeName;
					if($childCat->nodeName == "Tournament")
					{
						$idLeague     = $childCat->attributes->getNamedItem('id')->value;
						if(League::model()->findByPk($idLeague) == Null)
						{
							$leagueItem  = new League;
							$leagueItem->id      = $idLeague;
							$leagueItem->name    = $childCat->attributes->getNamedItem('name')->value;
							$leagueItem->country = $idCountry;
							$leagueItem->save();
						}
					}
				}
			}

			
		}
		
		
	}
	
}