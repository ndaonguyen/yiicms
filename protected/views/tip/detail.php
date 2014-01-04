<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Detail </h1>

<div>
	<table style="width: 600px">
		<tr>
			<td width="30%" >
				<?php
					$teamA_id   = $match->teamA_id;
					$teamA      = Team::model()->findByPk($teamA_id);
					echo $teamA->name;
				?>
			</td>
			
			<td width="40%" style="color:#DE185B" >
				<span><?php $league_id = $match->league_id ;
							$league    = League::model()->findByPk($league_id);
							echo $league->name; ?></span><br>
				<span><?php echo $match->time_match;?></span><br>
				<span><?php echo $match->status;?></span>
			</td>
			
			<td width="30%">
				<?php
					$teamB_id   = $match->teamB_id;
					$teamB      = Team::model()->findByPk($teamB_id);
					echo $teamB->name;
				?>
			</td>
		</tr>
    </table>	
</div>

<hr>
	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'tip-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'tip'); ?>
			<?php echo $form->textField($model,'tip'); ?>
			<?php echo $form->error($model,'tip'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'odds'); ?>
			<?php echo $form->textField($model,'odds'); ?>
			<?php echo $form->error($model,'odds'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'tip_who_id'); ?>
			<?php echo $form->textField($model,'tip_who_id'); ?>
			<?php echo $form->error($model,'tip_who_id'); ?>
		</div>
	
		<div class="row buttons">
			<?php echo CHtml::submitButton('Add Tip'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
	
<?php 
	if($tip != Null) // Add Tip
	{
	}
?>