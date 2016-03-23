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

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\server\ServerCommandEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginLoadOrder;
use pocketmine\utils\TextFormat;

class LazyPaml extends PluginBase implements Listener{
	/** @var string $NAME */
	private static $NAME;
	/** @var PamlLoader $pamlLoader */
	private $pamlLoader;

	public static function getNameStatic() : string{
		return self::$NAME;
	}

	public function onLoad(){
		self::$NAME = $this->getName();
	}

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerInterface(PamlLoader::class);
		$this->getServer()->getPluginManager()->loadPlugins($this->getServer()->getPluginPath(), [PamlLoader::class]);
		$this->getServer()->enablePlugins(PluginLoadOrder::STARTUP);
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	/**
	 * @param PlayerCommandPreprocessEvent $event
	 * @priority MONITOR
	 * @ignoreCancelled true
	 */
	public function onCmd(PlayerCommandPreprocessEvent $event){
		if($event->getMessage() === "/reload"){
			$event->getPlayer()->sendMessage(TextFormat::YELLOW . "Warning: LazyPaml plugins will NOT be loaded after reloading!");
			$this->getLogger()->warning("Warning: LazyPaml plugins will not be loaded after reloading!");
		}
	}

	public function onConsole(ServerCommandEvent $event){
		if($event->getCommand() === "reload"){
			$event->getSender()->sendMessage(TextFormat::YELLOW . "Warning: LazyPaml plugins will not be loaded after reloading!");
		}
	}

	public function setPamlLoader(PamlLoader $pamlLoader){
		if(isset($this->pamlLoader)){
			throw new \InvalidStateException("PamlLoader already set");
		}
		$this->pamlLoader = $pamlLoader;
	}

	public function getPamlLoader(){
		return $this->pamlLoader;
	}
}
