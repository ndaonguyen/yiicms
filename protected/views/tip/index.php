<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h3>List matches: </h3>

<div style="width: 40%">
	<div id="option" style="float: left; width: 40%">
		<span><?php echo CHtml::radioButtonList("matchDayOption","today",array('today'    =>'Today',
																		   'tomorrow' =>'Tomorrow',
																		   ),
												array(
												'onChange'    => CHtml::ajax(array(
													'type'    => 'POST',
													'data'    => array('dayOption'=>'js:this.value'),
													'url'     => CController::createUrl('tip/filter'),
													'update'  => '#datafilter',)))); ?></span><br>
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
																
		<span id="historyOption" style="visibility: hidden; "> 
			<div style="padding-top: 10px">
				<?php echo CHtml::dropDownList('history', '', $historyArray,
												array(
												'onChange'    => CHtml::ajax(array(
													'type'    => 'POST',
													'data'    => array('dayOption'=>'js:this.value'),
													'url'     => CController::createUrl('tip/filter'),
													'update'  => '#datafilter',))));?>
				
				<span id="upCommingOption" style="visibility: hidden"> 
					<?php echo CHtml::dropDownList("upcomming", '', $upcommingArray,
													array(
												'onChange'    => CHtml::ajax(array(
													'type'    => 'POST',
													'data'    => array('dayOption'=>'js:this.value'),
													'url'     => CController::createUrl('tip/filter'),
													'update'  => '#datafilter',)))) ?>
				</span>
			</div>
		</span>
		
		
	</div>
	
	<div style="float: left; width: 60%">
		<span><?php echo CHtml::textField("searchMatch","",array('id'=>'idSearch')); ?></span>
		<span>
			<?php echo CHtml::ajaxSubmitButton(Yii::t('searchTip','Search by team'),
        								CHtml::normalizeUrl(array('tip/search')),
        								array(
											'type'    => 'POST',
											'data'    => array('term'=>'js:document.getElementById("idSearch").value'),
											'url'     => CController::createUrl('tip/search'),
											'update'  => '#datafilter')); ?>
		</span>
		<span><?php // echo CHtml::button("Search", array("submit" => array("tip/search", array(/*'id'=>$data->linkId*/))));?></span>
		
	</div>
</div>

<hr style="width: 70%; margin-top: 10px; margin-bottom: 10px; ">

<div id="datafilter">
	<?php  $this->renderPartial('filterMatches',array('matches'=>$matches)); ?>
</div>

