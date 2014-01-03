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
		$this->render('index');
	}
	
	public function actionToday()
	{
		try {
			$path = Yii::app()->basePath."/utilities/Utility.php";
			include_once ($path);
			
			$daysUrl = Utility::getDaysLiveURL(0, 0);
			Utility::saveDaysRecordDb($daysUrl);
			echo "Today Done";
			$this->render('today');
		}
		catch(Exception $e)
		{
			echo $e;
		}
	}
	
	public function actionLastDays()
	{
		try {
			$path = Yii::app()->basePath."/utilities/Utility.php";
			include_once ($path);
				
			$daysUrl = Utility::getDaysLiveURL(-7, 0);
			Utility::saveDaysRecordDb($daysUrl);
			echo "Last Days Done";
			$this->render('last');
		}
		catch(Exception $e)
		{
			echo $e;
		}
	}
	
	public function actionNextDays()
	{
		try {
			$path = Yii::app()->basePath."/utilities/Utility.php";
			include_once ($path);
	
			$daysUrl = Utility::getDaysLiveURL(0, 10);
			Utility::saveDaysRecordDb($daysUrl);
			echo "Next Days Done";
			$this->render('next');
		}
		catch(Exception $e)
		{
			echo $e;
		}
	}
	
	
	public function actionAllDays()
	{
		try {
			$path = Yii::app()->basePath."/utilities/Utility.php";
			include_once ($path);
	
			$daysUrl = Utility::getDaysLiveURL(-7, 10);
			Utility::saveDaysRecordDb($daysUrl);
			echo "All Days Done";
			$this->render('all');
		}
		catch(Exception $e)
		{
			echo $e;
		}
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