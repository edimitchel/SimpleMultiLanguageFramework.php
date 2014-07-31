<?php 
	define("ROOT_PATH","..");
	include ROOT_PATH."/inc/Loader.php";
	include ROOT_PATH."/inc/MyCore.class.php";

	$page = PageContents::getPageContents("work");
	$page->addPage("eng", array(
		"title" => "Works",
		"description" => "All works that I've finished."
	));
	$page->addPage("fra", array(
		"title" => "Mes travaux",
		"description" => "Tous mes travaux déjà réalisés"
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