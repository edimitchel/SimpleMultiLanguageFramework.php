<?php 
	define("ROOT_PATH","..");
	include ROOT_PATH."/inc/Loader.php";
	include ROOT_PATH."/inc/MyCore.class.php";

	$page = PageContents::getPageContents("contactme");
	$page->addPage("eng", array(
		"title" => "Contact me",
		"description" => "We'll keep in touch."
	));
	$page->addPage("fra", array(
		"title" => "Contactez-moi",
		"description" => "Ecrivez moi, je vous réponds."
	));

	$core = MyCore::getInstance($page);
	$core->setAjaxRender(true);
?>
<?php $core->startSniffer('fra'); ?>
			<div class="page-content">
				<h1><?=$core->getTitle()?></h1>
				<h3>On reste en contact?</h3>
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="frm_mail">Votre adresse e-mail</label>
						<div class="col-sm-4">
							<input type="mail" name="email" id="frm_mail" class="form-control" placeholder="Votre adresse e-mail">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="frm_msg">Votre message</label>
						<div class="col-sm-4">
							<textarea name="message" id="frm_msg" class="form-control" placeholder="Votre message.."></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-2">
							<input type="submit" value="Envoi." class="btn btn-success">
						</div>
					</div>
				</form>
			</div>
<?php $core->getSnifferContent(); ?>

<?php $core->startSniffer('eng'); ?>
			<div class="page-content">
				<h1><?=$core->getTitle()?></h1>
				<h3>We keep in touch?</h3>
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="frm_mail">Your e-mail</label>
						<div class="col-sm-4">
							<input type="mail" name="email" id="frm_mail" class="form-control" placeholder="Your e-mail">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="frm_msg">Your message</label>
						<div class="col-sm-4">
							<textarea name="message" id="frm_msg" class="form-control" placeholder="Your message.."></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-2">
							<input type="submit" value="Send." class="btn btn-success">
						</div>
					</div>
				</form>
			</div>
<?php $core->getSnifferContent(); ?>
<?php $core->render(); ?>