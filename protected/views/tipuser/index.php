<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to Tip user</h1>
<div>
	<span><?php echo CHtml::textField("searchTipUser"); ?></span>
	<span><?php echo CHtml::button("Submit", array("submit" => array("tipuser/search", array('id'=>$data->linkId)))); ?></span>
	
	<span style="padding-left: 100px">
		<?php echo CHtml::button("(+) Create", array("submit" => array("tipuser/add"))); ?>
	</span>
</div>

<table class="dataGrid"  style="padding-top: 30px; width: 400px">
    <tr>
        <th width="40%"><?php echo Yii::t('ui','Name'); ?></th>
        <th width="40%"><?php echo Yii::t('ui','Description'); ?></th>
        <th width="10%"><?php echo Yii::t('ui','Edit'); ?></th>
        <th width="10%"><?php echo Yii::t('ui','Delete'); ?></th>
    </tr>    
    <?php 
    
    foreach($tip_users as $tip_user): ?>    
    <tr>
        <td><?php echo $tip_user->name; ?></td>
        <td><?php echo $tip_user->description;?></td>
        <td><?php echo CHtml::link("Edit",array('tipuser/edit',
                                         'id'=>$tip_user->id)); ?></td>
        <td><?php echo CHtml::link("Delete",array('tipuser/index'),
        		
				        		array(
				        				// for htmlOptions
				        				'onclick' => ' {' . CHtml::ajax(array(
												'data'=>array('id'=>$tip_user->id),
												'url'=>CController::createUrl('tipuser/delete'),
				        						'beforeSend' => 'js:function(){if(confirm("Are you sure you want to delete?"))return true;else return false;}',
				        						'success' => "js:function(html){ alert('removed'); }")) .
				        						'return false;}', // returning false prevents the default navigation to another url on a new page
												)
        			/*
        							array('onclick' => CHtml::ajax(array(
										  'type'=>'POST',
										  'dataType'=>'json',
										  'data'=>array('id'=>$tip_user->id),
										  'url'=>CController::createUrl('tipuser/delete'),
										  'success'=>'function(data){
											
											}',
									)))
					*/
									); ?></td>  
			
    </tr>
    <?php endforeach; ?>    
</table>
