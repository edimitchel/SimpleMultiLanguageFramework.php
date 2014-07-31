<?php 
	define("ROOT_PATH","..");
	include ROOT_PATH."/inc/Loader.php";
	include ROOT_PATH."/inc/MyCore.class.php";

	$page = PageContents::getPageContents("about");
	$page->addPage("eng", array(
		"title" => "About me",
		"description" => "All thing about me that you can know!"
	));
	$page->addPage("fra", array(
		"title" => "À propos",
		"description" => "Toutes les choses qui peuvent vous intéresser."
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