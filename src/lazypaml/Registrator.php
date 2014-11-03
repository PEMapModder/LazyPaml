<?php

namespace lazypaml;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginLoader;

class Registrator extends PluginBase implements PluginLoader{
	public function onEnable(){
		if($this->getServer()->getPluginManager()->registerInterface(self::class)){
			$this->getLogger()->info("Registered flowing plugin loader.");
		}
		else{
			$this->getLogger()->alert("Failed registering flowing plugin loader!");
			return;
		}
	}
	public function getPluginFilters(){
		return "/\\.php$/i";
	}
	public function loadPlugin($file){
		if(!is_file($file)){
			return null;
		}
		$src = file_get_contents($file);
		if(!(($desc = new FDescription($this, $src))) instanceof FDescription){
			return null;
		}
		$this->getLogger()->info("Loading LazyPaml plugin " . $desc->getFullName() . "...");
		$dataFolder = dirname($file) . DIRECTORY_SEPARATOR . $desc->getName();
		if(file_exists($dataFolder) and !is_dir($dataFolder)){
			$this->getLogger()->critical("Cannot load LazyPaml " . $desc->getName() . ": data folder is occupied by a non-folder.");
			return null;
		}
		return new FPlugin($this, $file, $desc, $dataFolder);
	}
	public function enablePlugin(Plugin $plugin){
		$plugin->onEnable();
	}
	public function disablePlugin(Plugin $plugin){
		$plugin->onDisable();
	}
	public function getPluginDescription($file){
		try{
			if(!is_file($file)){
				return null;
			}
			return new FDescription($this, file_get_contents($file));
		}
		catch(\RuntimeException $e){
			$this->getLogger()->critical("Unable to load plugin at $file: " . $e->getMessage());
			return null;
		}
	}
}
