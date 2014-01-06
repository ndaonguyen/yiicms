<div class="form" id="tipDialogForm">
 
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'tip-form',
    'enableAjaxValidation'=>false,
)); 
//I have enableAjaxValidation set to true so i can validate on the fly the
?>
 
    <p class="note">Fields with <span class="required">*</span> are required.</p>
 
    <?php echo $form->errorSummary($model); ?>
 
    <div class="row">
			<?php echo $form->labelEx($model,'tip'); ?>
			<?php // echo $form->textField($model,'tip'); ?>
			
			<?php 
					$listTeams  =  CHtml::listData(Team::model()->findAll(array(
											    'condition'=>'id='.$match->teamA_id.' OR id = '.$match->teamB_id,
													)),'id','name');
					$static     = array(
								    '0'     => Yii::t('fim','Other'), 
								);
					
					echo $form->dropDownList($model, 'tip', $listTeams + $static,
											array(
												'onChange' => '
																if(this.value == 0)
																	document.getElementById("tipOfOther").style.visibility="visible";
																else
																	document.getElementById("tipOfOther").style.visibility="hidden";
																')); ?> 
		
		<span class="row" id="tipOfOther" style="visibility: hidden">
			<?php echo $form->textField($model, 'tipOther'); ?>	
			<?php echo $form->error($model,'tipOther'); ?>	
		</span>
			
			<?php echo $form->error($model,'tip'); ?>
		</div>
	
		<div class="row" >
			<?php echo $form->labelEx($model,'odds (over 20. Number only)'); ?>
			<?php echo $form->textField($model,'odds'); ?>
			<?php echo $form->error($model,'odds'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'tip_who_id'); ?>
			<?php echo $form->dropDownList($model,'tip_who_id',  CHtml::listData(Tip_who::model()->findAll(), 'id', 'name')); ?>
			<?php echo $form->error($model,'tip_who_id'); ?>
		</div>
 
    <div class="row buttons">
        <?php echo CHtml::ajaxSubmitButton(Yii::t('job','Create Job'),
        								CHtml::normalizeUrl(array('tip/edit','render'=>false)),
        								array('success'=>'js: function(data) 
														{
									                        $("#tipDialog").dialog("close");
        													alert("hehe");
                    									}'),
        								array('id'=>'closeJobDialog')); ?>
    </div>
 
<?php $this->endWidget(); ?>
</div>