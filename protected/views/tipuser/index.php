<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h3>Welcome to Tip user</h3>
<div>
	<span><?php echo CHtml::textField("searchTipUser","",array('id'=>'idSearch')); ?></span>
	<span>
		<?php 
			echo CHtml::ajaxSubmitButton(Yii::t("searchUser", "Search"), CHtml::normalizeUrl(array("tipuser/search")),
										 array(
											"type"   => "POST",
											"data"   => array('term'=>'js:document.getElementById("idSearch").value'),
											"update" => "#datafilter",
											'url'     => CController::createUrl('tipuser/search'),
											));
		?>
	</span>
	
	<span style="padding-left: 100px">
		<?php echo CHtml::button("(+) Create", array("submit" => array("tipuser/add"))); ?>
	</span>
</div>


<div id="datafilter">
	<?php  $this->renderPartial('filterUser',array('tip_users'=>$tip_users)); ?>
</div>

