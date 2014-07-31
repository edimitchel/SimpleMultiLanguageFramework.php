<?php
/**
* My Core - Custom Engine
*/
class MyCore extends Core
{

	public static function getInstance($idPage){
		parent::getInstance($idPage);
		parent::$Instance->setHeaderFile("header.php");
		parent::$Instance->setFooterFile("footer.php");

		parent::$Instance->setDefaultTitle("Michel EDIGHOFFER - Développeur web");

		parent::$Instance->setMenuTitles(array(
			"eng" => array(
				"_home" => "Home",
				"about" => "About",
				"skill" => "Skill",
				"work" => "Work",
				"contactme" => "Contact me"
			),
			"fra" => array(
				"_home" => "Accueil",
				"about" => "À propos",
				"skill" => "Savoir-faire",
				"work" => "Travaux",
				"contactme" => "Ecrivez-moi"
			),
			"ger" => array(
				"_home" => "Hause",
				"about" => "Über",
				"skill" => "Können",
				"work" => "Leistung",
				"contactme" => "Kontakt"
			)
		));

		return parent::$Instance;
	}

}
?>