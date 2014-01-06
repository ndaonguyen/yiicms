<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>List matches: </h1>

<div style="width: 40%">
	<div id="option" style="float: left; width: 50%">
		<span><?php echo CHtml::radioButtonList("matchDayOption","today",array('today'    =>'Today',
																		   'tomorrow' =>'Tomorrow',
																		   ),
												array(
												'onChange' => ' {' . CHtml::ajax(array(
													'type'=>'POST',
													'dataType'=>'json',
													'data'=>array('dayOption'=>this.value),
													'url'=>CController::createUrl('tip/filter'),
													'update'=>'#listFilter',
 					        						'success' => "function(data)
																	 { 
					        											alert('kaka');
																	 }")) .
					        						'return false;}', )); ?></span><br>
		<span><?php echo CHtml::radioButtonList("matchDayOption","",array(
																		   'history'  =>'History',
																		   'upcomming'=>'Upcomming'),
												array(
												'onChange' => '
																if(this.value == "history")
																{
																	document.getElementById("historyOption").style.visibility="visible";
																	document.getElementById("upCommingOption").style.visibility="hidden";
																}
																else if(this.value == "upcomming")
																{
																	document.getElementById("historyOption").style.visibility="hidden";
																	document.getElementById("upCommingOption").style.visibility="visible";
																}
																')); ?></span>
																
		<span id="historyOption" style="visibility: hidden;"> 
			<div style="padding-top: 10px"><?php echo "History"?></div>
		</span>
		
		<span id="upCommingOption" style="visibility: hidden"> 
			<div style="padding-top: 10px"><?php echo "Upcomming"?></div>
		</span>
	</div>
	
	<div style="float: left; width: 50%">
		<span><?php echo CHtml::textField("searchMatch"); ?></span>
		<span><?php echo CHtml::button("Search", array("submit" => array("tip/search", array(/*'id'=>$data->linkId*/))));?></span>
		
	</div>
</div>

<hr style="width: 70%; margin-top: 10px; margin-bottom: 10px; ">

<div id="listFilter">
	<?php // $this->renderPartial('filterMatches',array('matchesFilter'=>$matchesFilter),false,true); ?>
</div>


<div id="listMatch" style="width: 50%">
<table class="dataGrid" >
    <tr>
        <th width="80%" align="center"><?php echo Yii::t('ui','Match'); ?></th>
        <th width="20%" align="center"><?php echo Yii::t('ui','Edit'); ?></th>
    </tr>    
    <?php 
    
    foreach($matches as $match): ?>    
    <tr id="<?php echo $match->id; ?>">
        <td>
        	<table>
				<tr>
					<td width="30%" >
						<?php
							$teamA_id   = $match->teamA_id;
							$teamA      = Team::model()->findByPk($teamA_id);
							echo $teamA->name;
						?>
					</td>
					
					<td width="40%" style="color:#DE185B" >
						<?php echo $match->time_match;?>
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
        </td>
        
        <td><?php echo CHtml::link("Detail Tips",array('tip/detail',
                                         'id'=>$match->id)); ?></td>
    </tr>
    <?php endforeach; ?>    
</table>
</div>