<?php

/*
 * LazyPaml
 *
 * Copyright (C) 2016 PEMapModder
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PEMapModder
 */

namespace LazyPaml;

use LazyPaml\API\LazyPamlApi;
use pocketmine\event\plugin\PluginEnableEvent;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginLoader;
use pocketmine\Server;

class PamlLoader implements PluginLoader{
	/** @var LazyPaml $main */
	private $main;

	/** @var LazyPamlApi[] */
	private $apiCache = [];

	public function __construct(Server $server){
		$this->main = $server->getPluginManager()->getPlugin(LazyPaml::getNameStatic());
		$this->main->setPamlLoader($this);
	}

	public function loadPlugin($file){
		$api = $this->parseFile($file);
		$this->main->getServer()->getLogger()->info($this->main->getServer()->getLanguage()->translateString("pocketmine.plugin.load", [$api->getDescription($this->main)->getFullName()]));
		return $api->loadPlugin($this->main);
	}

	public function getPluginDescription($file){
		return $this->parseFile($file)->getDescription($this->main);

	}

	public function getPluginFilters(){
		return "/\\.php$/i";
	}

	/**
	 * @param Plugin $plugin
	 *
	 * @return void
	 */
	public function enablePlugin(Plugin $plugin){
		if(!($plugin instanceof LazyPamlChildPlugin) or $plugin->isEnabled()){
			return;
		}
		$this->main->getServer()->getLogger()->info($this->main->getServer()->getLanguage()->translateString("pocketmine.plugin.enable", [$plugin->getDescription()->getFullName()]));
		$this->main->getServer()->getPluginManager()->callEvent(new PluginEnableEvent($plugin));
		$plugin->onEnable();
	}

	public function disablePlugin(Plugin $plugin){
		if(!($plugin instanceof LazyPamlChildPlugin)){
			throw new \InvalidArgumentException("Cannot disable non-LazyPaml plugin");
		}
		$plugin->onDisable();
	}

	public function parseFile(string $file) : LazyPamlApi{
		if(!isset($this->apiCache[$file])){
			global $LazyPaml;
			$LazyPaml = new LazyPamlApi();
			include_once $file;
			return $this->apiCache[$file] = $LazyPaml;
		}
		return $this->apiCache[$file];
	}
}
