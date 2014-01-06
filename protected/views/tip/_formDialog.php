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
												'options'  => array($activeTipId=>array('selected'=>true)),
												'onChange' => '
																if(this.value == 0)
																	document.getElementById("tipOfOtherForm").style.visibility="visible";
																else
																	document.getElementById("tipOfOtherForm").style.visibility="hidden";
																')); ?> 
		
		<span class="row" id="tipOfOtherForm" style="<?php if($activeTipId != 0) echo 'visibility: hidden'?> ">
			<?php if($activeTipId == 0) { $model->tipOther = $choosenTip->tip;  } ?>
			<?php echo $form->textField($model, 'tipOther'); ?>	
			<?php echo $form->error($model,'tipOther'); ?>	
		</span>
		
			<?php echo $form->error($model,'tip'); ?>
		</div>
	
		<div class="row" >
			<?php $model->odds = $choosenTip->odds; ?>
			<?php echo $form->labelEx($model,'odds (over 20. Number only)'); ?>
			<?php echo $form->textField($model,'odds'); ?>
			<?php echo $form->error($model,'odds'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'tip_who_id'); ?>
			<?php echo $form->dropDownList($model,'tip_who_id',  CHtml::listData(Tip_who::model()->findAll(), 'id', 'name'),
											array('options'  => array($choosenTip->tip_who_id => array('selected'=>true)))); ?>
			<?php echo $form->error($model,'tip_who_id'); ?>
		</div>
 
 	<?php echo $form->hiddenField($model,'match_id',array('value'=> $choosenTip->match_id)) ?>
 	<?php echo $form->hiddenField($model,'tip_id',array('value'  => $choosenTip->id)) ?>
 
    <div class="row buttons">
        <?php echo CHtml::ajaxSubmitButton(Yii::t('job','Update Tip'),
        								CHtml::normalizeUrl(array('tip/edit','render'=>false)),
        								array(
												'type'     =>'POST',
       											'dataType' =>'json',
												'success'=>'function(dataget) 
														{
        													var tipIndex0 = dataget.tipId + "0";
        													var tipIndex1 = dataget.tipId + "1";
        													var tipIndex2 = dataget.tipId + "2";
        										
        													document.getElementById(tipIndex0).innerHTML= dataget.tipNew;
        													document.getElementById(tipIndex1).innerHTML= dataget.oddNew;
        													document.getElementById(tipIndex2).innerHTML= dataget.tipWhoNew;
        										
        										 			$("#tipDialog1").dialog("close");
                    									}'),
        								array('id'=>'closeJobDialog')); ?>
    </div>
 
<?php $this->endWidget(); ?>
</div>