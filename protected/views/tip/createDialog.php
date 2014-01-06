<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'tipDialog',
                'options'=>array(
                    'title'=>Yii::t('tip','Update Tip'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'auto',
                    'height'=>'auto',
                ),
                ));
echo $this->renderPartial('_formDialog', array('model'=>$model, "tips"=>$tips, "match"=>$match),false,true); 
//Yii::app()->end();
?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>