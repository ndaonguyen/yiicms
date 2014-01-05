<?php
require_once($path = Yii::app()->basePath."/models/Team.php");
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
	//	$matchId    = $_GET['id'];
		$matchId    = 1310185514;
		$match      = MatchFootball::model()->findByPk($matchId);
		$tips       = Tip::model()->findAllByAttributes(array("match_id"=>$matchId));
		$model      = new TipForm();
		// Ajax Validation enabled
	//	$this->performAjaxValidation($model);
		// Flag to know if we will render the form or try to add
		// new jon.
		$flag=true;
		if(isset($_POST['TipForm']))
		{       
			$flag=false;
			$model->attributes=$_POST['TipForm'];
	
			if($model->save()) 
			{
				$i = 0;
				//Return an <option> and select it
/*
				echo CHtml::tag('option',array (
							'value'=>$model->jid,
							'selected'=>true
				),CHtml::encode($model->jdescr),true);
	*/
			}
		}
		if($flag) 
		{
		//	Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('createDialog',array("match"=>$match, "tips"=>$tips, 'model'=>$model,),false,true);
		}
	}
	
	public function actionIndex()
	{
		try {
		$matches = MatchFootball::model()->findAll();
		$this->render('index', array("matches"=>$matches));
		}
		catch (Exception $e)
		{
			echo $e;
		}
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
			
			$oddGet     = $model->odds;
			$odd        = 1 + $oddGet/20;
			$oddExp     = $this->simplify($oddGet,20);
			$wholeOddEx = $odd." or ".$oddExp[0]."/".$oddExp[1];
			$tipInsert->odds = $wholeOddEx;
			$tipInsert->save();
			$tips       = Tip::model()->findAllByAttributes(array("match_id"=>$matchId));
		}
		$this->render('detail', array("match"=>$match, "tips"=>$tips, 'model'=>$model));
	}
	
	public function gcd($x,$y)
	{
		do {
			$rest=$x%$y;
			$x=$y;
			$y=$rest;
		} while($rest!==0);
		return $x;
	}
	
	public function simplify($num,$den) 
	{
		$g = $this->gcd($num,$den);
		return Array($num/$g,$den/$g);
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
	
	


}