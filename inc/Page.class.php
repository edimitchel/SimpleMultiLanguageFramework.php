<?php
/**
* Page Class - Page description
*/
class PageContents
{
	public static $Instance = false;

	private $languages = array();

	private $idPage = false;

	private $title = array();

	private $description = array();

	private $content = array();

	private $coreParent = false;

	private function __construct(){}

	public static function getPageContents($idPage){
		if(self::$Instance === false){
			self::$Instance = new PageContents();
			self::$Instance->setIdPage($idPage);
		}

		return self::$Instance;
	}

	public function addPage($lang = false, $title = false, $description = false, $content = false)
	{
		if($lang === false)
			throw new Exception("A page must have a language.", 1);
		if($this->idPage === false)
			throw new Exception("The page id is unknow and is required. Please check the initialisation of this page contents.", 2);
			
		$this->languages[] = $lang;

		if(is_array($title) && isset($title['title'])){
			$this->setTitle($title['title'], $lang);
			if(isset($title['description']))
				$this->setDescription($title['description'], $lang);
			if(isset($title['content']))
				$this->setContent($title['content'], $lang);
		} else {
			$this->setTitle($title, $lang);
			$this->setDescription($description, $lang);
			$this->setContent($content, $lang);
		}
	}

	public function setIdPage($id){
		$this->idPage = $id;
	}

	public function getIdPage(){
		return $this->idPage;
	}

	public function getLanguages(){
		return $this->languages;
	}

	public function setCoreParent(Core $core){
		$this->coreParent = $core;
	}

	public function getCoreParent(){
		return $this->coreParent;
	}

	public function setTitle($title, $lang = false){
		$lang = $this->getCoreParent() !== false && $lang == false ? Core::getSiteLang() : $lang;
		$this->title[$lang] = $title;
	}

	public function getTitle($withSuffix){
		if($this->getCoreParent() !== false){
			if(!isset($this->title[Core::getSiteLang()]) || $this->title[Core::getSiteLang()] == false)
				return $this->coreParent->getDefaultTitle();
			else 
				return $withSuffix ? $this->title[Core::getSiteLang()] . ' - ' . $this->coreParent->getDefaultTitle() : $this->title[Core::getSiteLang()];
			return $this->title[Core::getSiteLang()];
		}
		else throw new Exception("The Core engine must be attached.");
	}

	public function setDescription($description, $lang = false){
		$lang = $this->getCoreParent() !== false && $lang == false ? Core::getSiteLang() : $lang;
		$this->description[$lang] = $description;
	}

	public function getDescription(){
		if($this->getCoreParent() !== false){
			return $this->description[Core::getSiteLang()] !== false ? $this->description[Core::getSiteLang()] : "";
		}
		else throw new Exception("The Core engine must be attached.");
	}

	public function setContent($content, $lang = false){
		$lang = $this->getCoreParent() !== false && $lang == false ? Core::getSiteLang() : $lang;
		$this->content[$lang] = $content;
	}

	public function getContent(){
		if($this->getCoreParent() !== false){
			return $this->content[Core::getSiteLang()] !== false ? $this->content[Core::getSiteLang()] : "";
		}
		else throw new Exception("The Core engine must be attached.");
	}

}
?>