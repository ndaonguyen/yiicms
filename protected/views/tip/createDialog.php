<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'tipDialog1',
                'options'=>array(
                    'title'=>Yii::t('tip','Update Tip'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'auto',
                    'height'=>'auto',
                ),
                ));
echo $this->renderPartial('_formDialog', array("match"=>$match, 'choosenTip'=>$choosenTip,
													  "activeTipId" => $activeTipId, 'model'=>$model,),false,true); 
Yii::app()->end();
?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>