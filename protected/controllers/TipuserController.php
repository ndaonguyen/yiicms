<?php
require_once($path = Yii::app()->basePath."/models/Tip_who.php");

class TipuserController extends Controller
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
		$tip_users = Tip_who::model()->findAll();
		$this->render('index', array("tip_users"=>$tip_users));
		}
		catch(Exception $e)
		{
			echo $e;
		}
	}
	
	public function actionAdd()
	{
		$model = new TipuserForm;
		if(isset($_POST['TipuserForm']))
		{
			$model->attributes=$_POST['TipuserForm'];
			if(!$model->validate())
				$this->redirect("?r=tipuser/index");
			
			if(Tip_who::model()->findByAttributes(array('name'=>$model->name)) != Null)
				$this->redirect("?r=tipuser/index");
			
			$tip_user = new Tip_who();
			$tip_user->name = $model->name;
			$tip_user->description = $model->description;
			$tip_user->save();
			$this->redirect("?r=tipuser/index");
			
			$this->redirect(Yii::app()->user->returnUrl);
			
			echo "Add User success!!";
		}
		$this->render('add',array('model'=>$model));
	}
	
	public function actionSearch()
	{
		$term       = $_POST['term'];
		$tip_users  = Tip_who::model()->findAll(array(
				'condition' => "t.name LIKE '%".$term."%'"));
		
		$this->renderPartial('filterUser',array("tip_users"=>$tip_users),false,true);
	}
	
	public function actionEdit()
	{
		$model     = new TipuserForm;
		$idTipUser = $_GET['id'];
		$tipUSer   = Tip_who::model()->findByPk($idTipUser);
		if(isset($_POST['TipuserForm']))
		{
			$model->attributes=$_POST['TipuserForm'];
			if(!$model->validate())
				$this->redirect("?r=tipuser/index");
				
			Tip_who::model()->updateAll(array( 'name' => $model->name, 'description' => $model->description ), 'id = '.$idTipUser );
			$this->redirect("?r=tipuser/index");
			echo "Update User success!!";
		}
		$this->render('edit',array('model'=>$model,'tipUSer'=>$tipUSer));
	}
	
	public function actionDelete()
	{
		$idTipUser = (int) $_POST['id'];
		Tip_who::model()->deleteByPk($idTipUser);
		echo CJSON::encode(array('idUser'=>$idTipUser));
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