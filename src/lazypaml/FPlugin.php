<?php

namespace lazypaml;

use lazypaml\api\Flow;
use pocketmine\command\Command;
use pocketmine\plugin\Plugin;

/** @noinspection PhpHierarchyChecksInspection TODO */
class FPlugin implements Plugin{
	private $main;
	private $file;
	private $description;
	private $dataFolder;
	private $enabled;
	public function __construct(Registrator $main, $file, FDescription $description, $dataFolder){
		$this->main = $main;
		$this->file = $file;
		$this->description = $description;
		$this->dataFolder = $dataFolder;
		$this->init();
	}
	private function init(){
		require_once $this->file;
	}
	public function getFile(){
		return $this->file;
	}
	public function getDescription(){
		return $this->description;
	}
	public function getDataFolder(){
		return $this->dataFolder;
	}

	public function onLoad(){}
	public function onEnable(){
		$this->enabled = true;
		call_user_func($this->getDescription()->getEntryPoint(), new Flow($this));
	}
	public function registerCommand(Command $cmd){
		$this->getServer()->getCommandMap()->register($this->getName(), $cmd);
	}
}
