<?php

namespace flowingplugin;

use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginLoader;

class Registrator extends PluginBase implements PluginLoader{
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerInterface(self::class) and $this->gteLogger()->info("Registered flowing plugin loader.") or $this->getLogger()->alert("Failed registering flowing plugin loader!");
	}
	public function getPluginFilters(){
		return "/\\.php$/i";
	}
}
