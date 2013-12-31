<?php
/* @var $this SiteController */

$this->pageTitle="Ask";
?>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ask-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content', array('rows' => 6, 'cols' => 50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php echo CHtml::label("", 'tags',array('id'=>'tagLabel')) ?>
		<?php echo $form->dropDownList($model, 'tags', CHtml::listData(Tag::model()->findall(),'id','name'),
										array('empty' => 'Select a category',
												'onChange' => CHtml::ajax(array(
												'type'=>'POST',
												'dataType'=>'json',
												'data'=>array('id'=>'js:this.value'),
												'url'=>CController::createUrl('question/addText'),
												'success'=>'function(data){
													$("#tagLabel").html("bum");
													}',
										)))); ?>
		<?php echo $form->error($model,'tags'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Ask'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->