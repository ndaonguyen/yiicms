<table class="dataGrid"  style="padding-top: 30px; width: 400px">
    <tr>
        <th width="40%"><?php echo Yii::t('ui','Name'); ?></th>
        <th width="40%"><?php echo Yii::t('ui','Description'); ?></th>
        <th width="10%"><?php echo Yii::t('ui','Edit'); ?></th>
        <th width="10%"><?php echo Yii::t('ui','Delete'); ?></th>
    </tr>    
    <?php 
    
    foreach($tip_users as $tip_user): ?>    
    <tr id="<?php echo  $tip_user->id; ?>">
        <td><?php echo $tip_user->name; ?></td>
        <td><?php echo $tip_user->description;?></td>
        <td><?php echo CHtml::link("Edit",array('tipuser/edit',
                                         'id'=>$tip_user->id)); ?></td>
        <td><?php echo CHtml::link("Delete",array('tipuser/index'),
				        		array(
			        				  'onclick' => ' {' . CHtml::ajax(array(
													'type'=>'POST',
													'dataType'=>'json',
													'data'=>array('id'=>$tip_user->id),
													'url'=>CController::createUrl('tipuser/delete'),
					        						'beforeSend' => 'js:function(){if(confirm("Are you sure you want to delete?"))return true;else return false;}',
					        						'success' => "function(data)
																	 { 
					        											if(data.idUser!=0)
					        											{
					        												var row = document.getElementById(data.idUser);
					        												row.parentElement.removeChild(row);
					        											}
																	 }")) .
					        						'return false;}', 
													)
									); ?></td>  
    </tr>
    <?php endforeach; ?>    
</table>