<?php 
	define("ROOT_PATH","..");
	include ROOT_PATH."/inc/Loader.php";
	include ROOT_PATH."/inc/MyCore.class.php";

	$page = PageContents::getPageContents("skill");
	$page->addPage("eng", array(
		"title" => "Skill",
		"description" => "All things that I can do!"
	));
	$page->addPage("fra", array(
		"title" => "Mon savoir-faire",
		"description" => "Tout ce que je sais faire!"
	));

	$core = MyCore::getInstance($page);
	$core->setAjaxRender(true);
?>
<?php $core->startSniffer('fra'); ?>
			<div class="page-content">
				<h1><?=$core->getTitle()?></h1>
				<p>A ECRIRE</p>
			</div>
<?php $core->getSnifferContent(); ?>

<?php $core->startSniffer('eng'); ?>
			<div class="page-content">
				<h1><?=$core->getTitle()?></h1>
				<p>TO WRITE</p>
			</div>
<?php $core->getSnifferContent(); ?>
<?php $core->render(); ?>