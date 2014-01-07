<?php
/* @var $this SiteController */
echo CHtml::link("Home", array("tip/index")). " >> ". CHtml::link("Tip-user", array("tipuser/index")). " >> Add "   ;
echo "<br>";
$this->pageTitle=Yii::app()->name;
?>

<div class="form"  style="padding-top:30px ">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tipuser-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'other'); ?>
		<?php echo $form->textField($model,'other'); ?>
		<?php echo $form->error($model,'other'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->