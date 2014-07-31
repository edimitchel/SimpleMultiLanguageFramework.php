<?php
session_start();
/**
* Page Core - Engine for page generation
*/
class Core
{
	public static $Instance = false;

	public static $LANGS = ['eng','fra'];
	public static $DEFAULTLANG = "eng";

	public static $LANGNAME = array(
		"fra"=> "Français",
		"eng"=> "English",
		"ger"=> "Deutsch",
		"esp"=> "Español",
		"sui"=> "Schweiz",
		"als"=> "Elsässisch"
	);

	private static $SITELANG = false;

	/**
	 * The default title if user is at home.
	 * Else, this title is suffixed at the title page.
	*/
	private $defaultTitle;

	private $menuTitles;

	private $currentPage = false;

	private $HeaderFile = false;

	private $FooterFile = false;

	private $ajaxRender = false;


	/**
	 *	Attributes for content sniffer
	*/

	private $currentLangContentSniffer = false;

	private function __construct(){}

	public static function getInstance(PageContents $page = NULL){
		if(self::$Instance === false){
			self::$Instance = new Core();
			self::$Instance->init();
			if($page !== NULL)
				self::$Instance->setCurrentPage($page);
		}

		return self::$Instance;
	}

	public function init(){
		if(isset($_COOKIE['lang']) && !empty($_COOKIE['lang']) && in_array($_COOKIE['lang'], self::$LANGS))
			self::$SITELANG = $_COOKIE['lang'];
		else if(isset($_SESSION['lang']) && !empty($_SESSION['lang']) && in_array($_SESSION['lang'], self::$LANGS))
			self::$SITELANG = $_SESSION['lang'];
		else
			self::$SITELANG = self::$DEFAULTLANG;

	}

	public function getIdPage(){
		return $this->currentPage->getIdPage();
	}

	public static function getSiteLang(){
		return in_array(self::$SITELANG,self::$Instance->currentPage->getLanguages()) ? self::$SITELANG : self::$DEFAULTLANG;
	}

	public function setDefaultTitle($title){
		$this->defaultTitle = $title;
	}

	public function getDefaultTitle(){
		return $this->defaultTitle;
	}

	protected function setMenuTitles($menuTitles){
		$this->menuTitles = $menuTitles;
	}

	public function getMenuTitles(){
		return $this->menuTitles;
	}

	protected function setCurrentPage(PageContents $page = NULL){
		if($page !== NULL){
			$this->currentPage = $page;
			$page->setCoreParent($this);
		}
	}

	public function getCurrentPage(){
		return $this->currentPage;
	}

	public function setHeaderFile($file){
		$this->HeaderFile = $file;
	}

	public function getHeader(){
		if($this->HeaderFile !== false)
			include $this->HeaderFile;
	}

	public function getContent(){
		return $this->currentPage->getContent();
	}

	public function setTitle($title){
		$this->currentPage->setTitle($title);
	}

	public function getTitle($withSuffix = false){
		return $this->currentPage->getTitle($withSuffix);
	}
	
	public function setDescription($description){
		$this->currentPage->description = $description;
	}

	public function getDescription(){
		return $this->currentPage->getDescription();
	}

	public function setFooterFile($file){
		$this->FooterFile = $file;
	}

	public function getFooter(){
		if($this->FooterFile !== false)
			include $this->FooterFile;
	}

	public function setAjaxRender($enable){
		$this->ajaxRender = (bool) $enable;
	}

	public function haveAjaxRender(){
		return $this->ajaxRender;
	}

	public function render(){
		if($this->currentLangContentSniffer !== false)
			throw new Exception("Sniffer is almost waiting the getSnifferContent method.", 1);
			
		if(isset($_GET['ajax']) && isset($_GET['langOri']) && $this->haveAjaxRender()){
			header('Content-type: application/json');
			$langOri = $_GET['langOri'];
			$object =  (object) array(
				"lang" => $this->getSiteLang(),
				"usrlang" => Core::$SITELANG,
				"idpage" => $this->getIdPage(),
				"title" => $this->getTitle(true),
				"description" => $this->getDescription(),
				"content" => $this->getContent()
			);
			if($langOri !== $this->getSiteLang()){
				// Page language undefined: we send the new menu of default language
				$object->menu = $this->getMenuTitles()[$this->getSiteLang()];
			}
			echo json_encode($object, false);
		return;
		} else {
			$this->getHeader();
			echo $this->getContent();
			$this->getFooter();
		}
		exit;
		return;
	}

	public function startSniffer($lang){
		if(in_array($lang, $this->currentPage->getLanguages())){
			$this->currentLangContentSniffer = $lang;
			ob_start();
		} else {
			throw new Exception("The content sniffer can't get content with this language (\"".$lang."\"). Please check if the page contents get this language.", 1);
		}
	}

	public function getSnifferContent(){
		if($this->currentLangContentSniffer !== false){
			$content = ob_get_clean();
			$this->currentPage->setContent($content,$this->currentLangContentSniffer);
			$this->currentLangContentSniffer = false;
		}
	}
}
?>