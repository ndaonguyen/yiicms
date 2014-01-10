<?php
class DataController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$state = Utility::checkLoginState();
		if($state == false)
			$this->redirect("?r=site/login");
		
		$this->render('index');
	}
	
	
	public function actionDeleteAll()
	{
		try {
			Utility::deleteDataTable("Country");
			Utility::deleteDataTable("Team");
			Utility::deleteDataTable("Goal");
			Utility::deleteDataTable("League");
			Utility::deleteDataTable("Match");
			Utility::deleteDataTable("Tip");
			Utility::deleteDataTable("Tip_who");
			
			$this->render('delete');
		}
		catch(Exception $e)
		{
			echo $e;
		}
	}
	
	public function actionToday()
	{
		$state = Utility::checkLoginState();
		if($state == false)
			$this->redirect("?r=site/login");
		
		$daysUrl = Utility::getDaysLiveURL(0, 0);
		Utility::saveDaysRecordDb($daysUrl);
		
		$this->render('today');
	}
	
	public function actionLastDays()
	{
		$state = Utility::checkLoginState();
		if($state == false)
			$this->redirect("?r=site/login");
		
		$daysUrl = Utility::getDaysLiveURL(Conf::$numReadHistory, 0);
		Utility::saveDaysRecordDb($daysUrl);
		
		$this->render('last');
	}
	
	public function actionNextDays()
	{
		$state = Utility::checkLoginState();
		if($state == false)
			$this->redirect("?r=site/login");
		
		$daysUrl = Utility::getDaysLiveURL(0, 10);
		Utility::saveDaysRecordDb($daysUrl);
		
		$this->render('next');
	}
	
	
	public function actionAllDays()
	{
		$state = Utility::checkLoginState();
		if($state == false)
			$this->redirect("?r=site/login");
		
		$daysUrl = Utility::getDaysLiveURL(Conf::$numReadHistory, Conf::$numUpCommingDay);
		Utility::saveDaysRecordDb($daysUrl);
		
		$this->render('all');
	}
	

	/**
	 * This is the action to handle external exceptions.
	 */
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