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
	<h5 style="color: #851304">Add Tip for this match:</h5>
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
			<?php echo CHtml::submitButton('Add Tip'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->

<hr>
<?php 
	if(count($tips) > 0 ) // show tip
	{
?>
		<h5  style="color: #851304">Current Tips for this match:</h5>
		<table  style="width: 600px">
		  <tr>
		    <th width="40%">Tips</th>
		    <th width="20%">Odds</th>
		    <th width="20%">Who</th>
		    <th width="10%">Edit</th>
		    <th width="10%">Delete</th>
		  </tr>
		    
		

<?php 
		foreach($tips as $tip)
		{
?>
		<tr id = "<?php echo $tip->id; ?>">
			<td id = "<?php echo $tip->id.'0'; ?>"><?php echo $tip->tip; ?></td>
		    <td id = "<?php echo $tip->id.'1'; ?>"><?php echo Utility::getOddsStr($tip->odds); ?></td>
		    <td id = "<?php echo $tip->id.'2'; ?>"><?php $tip_who = Tip_who::model()->findByPk($tip->tip_who_id);
		    		  echo $tip_who->name; ?></td>
		   	<td>
                <?php echo CHtml::ajaxLink(Yii::t('tip','Update'),
                						$this->createUrl('tip/edit'),
                						array(
									        'onclick'=>'$("#tipDialog").dialog("open"); return false;',
									        'update'=>'#tipDialog',
											'type'=>'POST',
											'data'=>array('match_id'=>$tip->match_id, 'tip_id' => $tip->id),
									        ));?>
    					<div id="tipDialog"></div>
    		</td>
    		
    		
        	<td><?php echo CHtml::link("Delete",array('tip/detail',array("id"=>$tip->id)),
				        		array(
			        				  'onclick' => ' {' . CHtml::ajax(array(
													'type'=>'POST',
													'dataType'=>'json', // must
													'data'=>array('id'=>$tip->id),
													'url'=>CController::createUrl('tip/delete'),
					        						'beforeSend' => 'js:function(){if(confirm("Are you sure you want to delete?"))return true;else return false;}',
					        						'success' => "function(data)
																	 { 
					        											if(data.idTip!=0)
					        											{
					        												var row = document.getElementById(data.idTip);
					        												row.parentElement.removeChild(row);
					        											}
																	 }")) .
					        						'return false;}', 
													)
									); ?></td>  
		</tr>
<?php
		}
?>
		</table>
<?php 
	}
?>