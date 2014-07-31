<!DOCTYPE html>
<html lang="<?=$this->getSiteLang()?>" usr-lang="<?=Core::$SITELANG?>">
	<head>
		<meta charset="UTF-8">
		<title><?=$this->getTitle(true)?></title>
		<meta name="description" content="<?=$this->getDescription()?>">
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="<?=ROOT_PATH?>/css/interface.css">
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
	</head>
	<body<?php if(Core::getIdPage() !== "_home") echo " class=\"small-header\""; ?>>
		<header id="header">
			<div id="logo"<?php 
						if(Core::getIdPage() == "_home") echo " class=\"active\"";
					?>><a href="<?=ROOT_PATH?>/"><?=$this->getMenuTitles()[$this->getSiteLang()]['_home']?></a></div>
			<div id="langSwitcher">
				<div data-lang="<?=$this->getSiteLang()?>" class="lang"><?=Core::$LANGNAME[$this->getSiteLang()]?></div>
				<?php foreach(Core::$LANGS AS $i => $lang): if($this->getSiteLang() != $lang):?>
					<div data-lang="<?=$lang?>" class="lang other hideLang"><?=Core::$LANGNAME[$lang]?></div>
				<?php endif; endforeach; ?>
			</div>
			<nav>
				<ul>
<?php $menuList = $this->getMenuTitles()[$this->getSiteLang()]; foreach ($menuList as $id => $mTitle): 
	if(strpos($id, "_") === false): ?>
					<li<?php 
						if(Core::getIdPage() == $id) echo " class=\"active\"";
					?> id="mn-<?=$id?>"><a href="<?=ROOT_PATH?>/<?=$id?>"><span><?=$mTitle?></span></a></li>
<?php endif; endforeach ?>
				</ul>
				<div class="clearfix"></div>
			</nav>
		</header>
		<section id="content">