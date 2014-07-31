<?php
	session_start();
	if(isset($_GET['langToChange']) && !empty($_GET['langToChange'])) {
		$lang = $_GET['langToChange'];

		setcookie("lang",$lang,time()+3600*24*365,'/');
		$_SESSION['lang'] = $lang;

		header('Content-type: application/json');
		echo json_encode(array("ok"=>true, "lang"=>$lang));
	}
?>