<?php
require_once($path = Yii::app()->basePath."/models/Team.php");
require_once($path = Yii::app()->basePath."/utilities/Utility.php");


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
			
			Tip::model()->updateByPk($tip_id, array('tip' => $tipStrInsert, 'odds' => $model->odds, 'tip_who_id' => $model->tip_who_id));
			
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
													  "activeTipId" => $activeTipId, 'model'=>$model,),false,true);
		}
	}
	
	public function actionIndex()
	{
		try 
		{
			$today  = date('Y-m-d');
			$matches = MatchFootball::model()->findAll(array(
														    'condition' => "t.time_match LIKE '%".$today."%'",
														));
			$this->render('index', array("matches"=>$matches));
		}
		catch (Exception $e)
		{
			echo $e;
		}
	}
	
	
	public function actionFilter()
	{
		$numDayBeforeToday = 1;
		$tomorrow = date('Y-m-d', strtotime("+".$numDayBeforeToday." days"));
//		$today   = date('Y-m-d');
		$matchesFilter = MatchFootball::model()->findAll(array(
				'condition' => "t.time_match LIKE '%".$tomorrow."%'",
		));
		$this->renderPartial('filterMatches',array("matchesFilter"=>$matchesFilter),false,true);
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
			if(Tip::model()->findByAttributes(array("match_id"=>$matchId, "tip_who_id"=>$model->tip_who_id)) != Null)
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