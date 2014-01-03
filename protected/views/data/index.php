<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<?php echo CHtml::button("Read Today data", array("submit" => "?r=data/today"))?>

<?php echo CHtml::button("Last 7 days data", array("submit" => "?r=data/lastDays"))?>

<?php echo CHtml::button("Next 10 days data", array("submit" => "?r=data/nextDays"))?>

<?php echo CHtml::button("Read all data", array("submit" => "?r=data/allDays"))?>

<?php echo CHtml::button("Delete all data", array("submit" => "?r=data/deleteAll"))?>
