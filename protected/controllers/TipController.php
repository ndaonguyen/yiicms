<?php
require_once($path = Yii::app()->basePath."/models/Team.php");
require_once($path = Yii::app()->basePath."/utilities/Utility.php");
require_once($path = Yii::app()->basePath."/utilities/Conf.php");

class TipController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionEdit() 
	{
		$model      = new TipForm();
		$flag=true;
		if(isset($_POST['TipForm']))
		{       
			$flag=false;
			$model->attributes=$_POST['TipForm'];
			$tip_id  = $model->tip_id;
			
			$tipStrInsert = "";
			$tip     = $model->tip;
			if($tip == '0')
			{
				$tipStrInsert = $model->tipOther;
			}
			else
			{
				$teamTip = Team::model()->findByPk($tip);
				$tipStrInsert    = $teamTip->name;
			}
			
			Tip::model()->updateByPk($tip_id, array('tip' => $tipStrInsert, 'odds' => $model->odds, 
													'tip_who_id' => $model->tip_who_id));
			
			//pass new data for updating view
			$tipUpdate = Tip::model()->findByPk($model->tip_id);
			$tipNew    = $tipUpdate->tip;
			$oddNew    = Utility::getOddsStr($tipUpdate->odds);
			$tip_who   = Tip_who::model()->findByPk($tipUpdate->tip_who_id);
			$tip_who_str = $tip_who->name;
			
			
			echo CJSON::encode(array(
					'status'=>'success',
					'tipId' =>$tipUpdate->id,
					'tipNew'=>$tipNew,
					'oddNew'=>$oddNew,
					"tipWhoNew"=>$tip_who_str,
			));
		}
		
		if($flag) 
		{
			$matchId    = $_POST['match_id'];
			$tipId      = $_POST['tip_id'];
			
			$match      = MatchFootball::model()->findByPk($matchId);
			$choosenTip = Tip::model()->findByPk($tipId);
			$activeTipId= $this->getActiveTipMatchId($choosenTip, $match);
			
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('createDialog',array("match"=>$match, 'choosenTip'=>$choosenTip,
													  "activeTipId" => $activeTipId, 'model'=>$model,)
													  ,false,true);
		}
	}
	
	public function actionIndex()
	{
		$today    = date('Y-m-d');
		$criteria = new CDbCriteria();
		$criteria->condition = "time_match LIKE '%".$today."%'";
		$count    = MatchFootball::model()->count($criteria);
		$pages    = new CPagination($count);
		
		$pages->pageSize = Conf::$numItemPerDayTip;
		$pages->applyLimit($criteria);
		$matches = MatchFootball::model()->findAll($criteria);
		
		$historyDay  = Conf::$numHistoryDay;
		$historyArray = array();
		for($i = 1; $i <= $historyDay; $i++)
		{
			$dayInsertShow  = date('d/m/Y', strtotime("-".$i." days"));
			$dayInsertValue = date('Y-m-d', strtotime("-".$i." days"));
			$historyArray[$dayInsertValue] = $dayInsertShow;
		}
		
		$upcommingDay  = Conf::$numUpCommingDay;
		$upArray = array();
		for($i = 2; $i <= $upcommingDay; $i++)
		{
			$dayInsertShow  = date('d/m/Y', strtotime("+".$i." days"));
			$dayInsertValue = date('Y-m-d', strtotime("+".$i." days"));
			$upArray[$dayInsertValue] = $dayInsertShow;
		}
		
		$this->render('index', array(
				'matches'         => $matches,
				'pages'          => $pages,
				"historyArray"   => $historyArray,
				"upcommingArray" => $upArray 
		));
	}
	
	
	public function actionFilter()
	{
		$dayOption = $_POST['dayOption'];
		$dayChoose = "";
		if($dayOption == "tomorrow")
		{
			$numDayBeforeToday = 1;
			$dayChoose  = date('Y-m-d', strtotime("+".$numDayBeforeToday." days"));
		}
		elseif ($dayOption == "today")
		$dayChoose  = date('Y-m-d');
		else
			$dayChoose  = $dayOption;
		
		$criteria = new CDbCriteria();
		$criteria->condition = "time_match LIKE '%".$dayChoose."%'";
		$count    = MatchFootball::model()->count($criteria);
		$pages    = new CPagination($count);
		
		$pages->pageSize = Conf::$numItemPerDayTip;
		$pages->applyLimit($criteria);
		$matches = MatchFootball::model()->findAll($criteria);
		
		$this->renderPartial('filterMatches', array(
				'matches'        => $matches,
				'pages'          => $pages,
				),false,true);
	}
	
	public function actionSearch()
	{
		$criteria = new CDbCriteria();
		
		$term   = $_POST['term'];
		$teams  = Team::model()->findAll(array(
				'condition' => "t.name LIKE '%".$term."%'"));
		
		$countTeam      = count($teams);
		if($countTeam == 0)
			return $this->renderPartial('filterMatches', array(
				'matches'        => array(),
				'pages'          => Null,
				),false,true);
			
		$inConditionStr = "(";
		for($i = 0; $i<$countTeam; $i++)
		{
			$inConditionStr = $inConditionStr.$teams[$i]->id;
			if($i != ($countTeam-1) )
				$inConditionStr = $inConditionStr.",";
		}
		$inConditionStr = $inConditionStr.")";
		
		$criteria->condition = "teamA_id In ".$inConditionStr. " OR teamA_id IN ".$inConditionStr;
		$count    = MatchFootball::model()->count($criteria);
		$pages    = new CPagination($count);
		
		$pages->pageSize = Conf::$numItemPerDayTip;
		$pages->applyLimit($criteria);
		$matches = MatchFootball::model()->findAll($criteria);
	
		$this->renderPartial('filterMatches', array(
				'matches'        => $matches,
				'pages'          => $pages,
				),false,true);
	}
	
	
	public function actionDelete()
	{
		$idTipUser = (int) $_POST['id'];
		Tip::model()->deleteByPk($idTipUser);
		echo CJSON::encode(array('idTip'=>$idTipUser));
	}
	
	public function actionDetail()
	{
		$matchId    = $_GET['id'];
		$match      = MatchFootball::model()->findByPk($matchId);
		$tips       = Tip::model()->findAllByAttributes(array("match_id"=>$matchId));
		$model      = new TipForm;
		if(isset($_POST['TipForm']))
		{
			$model->attributes = $_POST['TipForm'];
			if(Tip::model()->findByAttributes(array("match_id"=>$matchId, 
											        "tip_who_id"=>$model->tip_who_id)) != Null)
				return $this->render('detail', array("match"=>$match, "tips"=>$tips, 'model'=>$model));
				
			$tipInsert = new Tip;
			$tip     = $model->tip;
			if($tip == '0')
			{
				$tipInsert->tip = $model->tipOther;
			}
			else 
			{
				$teamTip = Team::model()->findByPk($tip); 	
			 	$tipInsert->tip    = $teamTip->name;
			}
			$tipInsert->match_id   = $matchId;
			$tipInsert->tip_who_id = $model->tip_who_id;
		
			$tipInsert->odds =  $model->odds;
			$tipInsert->save();
			$tips       = Tip::model()->findAllByAttributes(array("match_id"=>$matchId));
		}
		$this->render('detail', array("match"=>$match, "tips"=>$tips, 'model'=>$model));
	}
	
	public function getOddsStr($oddInt)
	{
		$odd        = 1 + $oddInt/20;
		$oddExp     = $this->simplify($oddInt,20);
		$wholeOddEx = $odd." or ".$oddExp[0]."/".$oddExp[1];
		return $wholeOddEx;
	}
	
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	public function getActiveTipMatchId($choosenTip, $match)  // which team is win
	{
		$tipActiveId= 0;
		$tipStr     = $choosenTip->tip;
		$teamA      = Team::model()->findByPk($match->teamA_id);
		$teamA_name = $teamA->name;
		
		$teamB      = Team::model()->findByPk($match->teamB_id);
		$teamB_name = $teamB->name;
			
		if($tipStr == $teamA_name)
			$tipActiveId = $match->teamA_id;
		else if($tipStr == $teamB_name)
			$tipActiveId = $match->teamB_id;
		
		return $tipActiveId;
	}


}