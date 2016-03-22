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
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginLoader;
use pocketmine\plugin\PluginLogger;
use pocketmine\utils\Config;

class LazyPamlChildPlugin implements Plugin{
	/** @var LazyPaml */
	private $main;
	/** @var LazyPamlApi $api */
	private $api;
	/** @var bool $enabled */
	private $enabled = false;
	/** @var string $dataFolder */
	private $dataFolder;
	/** @var Config $config */
	private $config;
	/** @var PluginLogger $logger */
	private $logger;

	public function __construct(LazyPaml $main, LazyPamlApi $api){
		$this->main = $main;
		$this->api = $api;
		$this->dataFolder = $main->getServer()->getPluginPath() . $api->getName() . DIRECTORY_SEPARATOR;
		$this->logger = new PluginLogger($this);
	}

	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		// TODO: Implement onCommand() method.
	}

	public function onLoad(){
		// TODO: Implement onLoad() method.
	}

	public function onEnable(){
		$this->enabled = true;
	}

	public function isEnabled(){
		return $this->enabled;
	}

	public function onDisable(){
		$this->enabled = false;
	}

	public function isDisabled(){
		return !$this->enabled;
	}

	public function getDataFolder(){
		return $this->dataFolder;
	}

	public function getDescription(){
		return $this->api->getDescription();
	}

	public function getResource($filename){
		return null;
	}

	public function saveResource($filename, $replace = false){
		return false;
	}

	public function getResources(){
		return [];
	}

	public function getConfig(){
		if(!isset($this->config)){
			$this->reloadConfig();
		}
		return $this->config;
	}

	public function saveConfig(){
		$this->config->save();
	}

	public function saveDefaultConfig(){
		return false;
	}

	public function reloadConfig(){
		$this->config = new Config($this->dataFolder . "config.yml", Config::YAML);
	}

	public function getServer(){
		return $this->main->getServer();
	}

	public function getName(){
		return $this->api->getName();
	}

	/**
	 * @return PluginLogger
	 */
	public function getLogger(){
		return $this->logger;
	}

	/**
	 * @return PluginLoader
	 */
	public function getPluginLoader(){
		return $this->main->getPamlLoader();
	}
}
