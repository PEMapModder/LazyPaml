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

use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginLoadOrder;

class LazyPaml extends PluginBase{
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
