<?php 
if(count($matches) > 0)
{
?>
	<table class="dataGrid1" style="width: 50%" >
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
                                         'id'=>$match->id)); ?>
        </td>
    </tr>
    <?php endforeach;
?>
</table>

<hr>
<?php $this->widget('CLinkPager', array(
    'pages' => $pages,
)) ?>
<?php 
}
else 
	echo "No match found !!";
?>    
