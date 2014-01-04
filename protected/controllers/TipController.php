<?php

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
	
	public function actionDetail()
	{
		$matchId = $_GET['id'];
		$match   = MatchFootball::model()->findByPk($matchId);
		$tip     = Tip::model()->findByAttributes(array("match_id"=>$matchId));
		$model = new TipForm;
		$this->render('detail', array("match"=>$match, "tip"=>$tip, 'model'=>$model ));
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