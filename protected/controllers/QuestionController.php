<?php

class QuestionController extends Controller
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
	public function actionAsk()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$model = new AskForm;
		if(isset($_POST['AskForm']))
		{
			$model->attributes=$_POST['AskForm'];
			if(!$model->validate())
				return ;
			
			$question = new Question();
			$question->title    = $model->title;
			$question->content  = $model->content;
			
			$tags    = $model->tags;
			
			
			$tagArr  = explode(",", $tags);
			if(count($tagArr) <= 0)
				return;
			
			$result = $question->save();
			$lastQuestionId = Yii::app()->db->getLastInsertId();
			foreach ($tagArr as $tag)
			{
				$questionTag = new QuestionTag();
				$questionTag->question_id = $lastQuestionId;
				$questionTag->tag_id = $tag;
				$questionTag->save();				
			}
			if($result)
				$this->redirect(array("Site/index"));
		}
		$this->render('ask',array('model'=>$model));
	}
	
	public function actionAddText()
	{
		$tag_id = (int) $_POST['tag_id'];
		$k = $tag_id;
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