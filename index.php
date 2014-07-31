<?php
	define("ROOT_PATH",".");
	include ROOT_PATH."/inc/Loader.php";
	include ROOT_PATH."/inc/MyCore.class.php";

	$page = PageContents::getPageContents("_home");
	$page->addPage("eng", array(
		"title" => "Home",
		"description" => "You're at my home."
	));
	$page->addPage("fra", array(
		"title" => "Mon chez moi",
		"description" => "Vous êtes chez moi."
	));
	$page->addPage("ger", array(
		"title" => "Heimat",
		"description" => "Sie sind zu Hause."
	));

	$core = MyCore::getInstance($page);
	$core->setAjaxRender(true);

	$core->startSniffer('fra'); ?>
			<div class="page-content">
				<h1><?=$core->getTitle()?></h1>
				<p>Texte en français</p>
			</div>
<?php 
	$core->getSnifferContent();
	$core->startSniffer('eng'); ?>
			<div class="page-content">
				<h1><?=$core->getTitle()?></h1>
				<p>Text in english</p>
			</div>
<?php 
	$core->getSnifferContent();
	$core->render(); 
?>
		