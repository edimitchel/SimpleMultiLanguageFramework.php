<?php 
	session_start();
	$LANGS = ['en','fr'];
	$DEFAULTLANG = $LANGS[1];

	/**
	 * The default title if user is at home.
	 * Else, this title is suffixed at the title page.
	*/
	$defaultTitle = "Michel EDIGHOFFER - Développeur web";

	$menuTitles = array(
		"en" => array(
			"_home" => "Home",
			"about" => "About",
			"skill" => "Skill",
			"work" => "Work",
			"contactme" => "Contact me"
		),
		"fr" => array(
			"_home" => "Accueil",
			"about" => "À propos",
			"skill" => "Savoir-faire",
			"work" => "Travaux",
			"contactme" => "Ecrivez-moi"
		)
	);

	$currentPage = false;

	function init($data){
		ob_start();
		$data = (object) $data;
		global $LANGS, $DEFAULTLANG, $defaultTitle, $menuTitles, $currentPage;

		if(isset($_COOKIE['lang']) && !empty($_COOKIE['lang']) && in_array($_COOKIE['lang'], $LANGS))
			define('SITELANG', $_COOKIE['lang']);
		else if(isset($_SESSION['lang']) && !empty($_SESSION['lang']) && in_array($_SESSION['lang'], $LANGS))
			define('SITELANG', $_SESSION['lang']);
		else
			define('SITELANG', $DEFAULTLANG);

		$titlePage = false;
		$description = false;

		if(isset($data->idpage))
			$idPage = $data->idpage;
		//else return;
		$lang = SITELANG;
		$info = (object) $data->$lang;

		if(isset($info->title))
			$titlePage = $info->title;

		if(isset($info->description))
			$description = $info->description;

		if(!defined('IDPAGE'))
			define('IDPAGE', $idPage);

		$currentPage = (object) array(
			"lang" => SITELANG,
			"idpage" => IDPAGE,
			"title" => $titlePage,
			"description" => $description,
			"content" => ""
		);
	}


	function getHeader(){
		global $menuTitles;
		include "header.php";
	}

	function getFooter(){
		include "footer.php";
	}

	function render(){
		global $LANGS, $DEFAULTLANG, $defaultTitle, $menuTitles, $currentPage;

		if(isset($_GET['ajax'])){
			header('Content-type: application/json');
			$content = ob_get_clean();
			$currentPage->content = $content;
			echo json_encode($currentPage, false);
			exit;
		} else {
			$content = ob_get_clean();
			$currentPage->content = $content;
			getHeader();
			echo getCurrentContent();
			getFooter();
		}
	}

	function getCurrentTitle($withSuffix = false){
		global $currentPage, $defaultTitle;
		if(!isset($currentPage->title) || $currentPage->title == false)
			return $defaultTitle;
		else 
			return $withSuffix ? $currentPage->title . ' - ' . $defaultTitle : $currentPage->title;
	}

	function getCurrentDescription(){
		global $currentPage;
		if(!isset($currentPage->title)) return false;
		return $currentPage->description;
	}

	function getCurrentContent(){
		global $currentPage;
		if(!isset($currentPage->content)) return false;
		return $currentPage->content;
	}
?>