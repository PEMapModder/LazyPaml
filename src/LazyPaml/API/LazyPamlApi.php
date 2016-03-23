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

namespace LazyPaml\API;

use LazyPaml\API\Permission\PermissionLoader;
use LazyPaml\LazyPaml;
use LazyPaml\LazyPamlChildPlugin;
use pocketmine\plugin\PluginDescription;
use pocketmine\plugin\PluginLoadOrder;

class LazyPamlApi{
	// registered
	/** @var string $name */
	private $name;
	/** @var string $version */
	private $version;
	/** @var int $api */
	private $api;
	/** @var string[] $loadBefore */
	private $loadBefore = [];
	/** @var string[] $loadAfter */
	private $softDepend = [];
	/** @var string|null $website */
	private $website = null;
	/** @var string|null $strDescription */
	private $strDescription = null;
	/** @var string|null $prefix */
	private $prefix = null;
	/** @var int $load */
	private $load = "POSTWORLD";
	/** @var string|null $author */
	private $author = null;
	/** @var string[] $authors */
	private $authors = [];
	/** @var array[] $permissionsArray */
	private $permissionsArray = [];
	/** @var PermissionLoader $Permissions */
	public $Permissions;

	// caches
	/** @var PluginDescription $description */
	private $description;

	#############
	# API START #
	#############

	public function Name(string $name) : LazyPamlApi{
		$this->name = $name;
		return $this;
	}

	public function Version(string $version)  : LazyPamlApi{
		$this->version = $version;
		return $this;
	}

	public function API(int $api) : LazyPamlApi{
		$this->api = $api;
		return $this;
	}

	public function Load_before(string $otherName) : LazyPamlApi{
		$this->loadBefore[] = $otherName;
		return $this;
	}

	public function Load_after(string $otherName) : LazyPamlApi{
		$this->softDepend[] = $otherName;
	}

	public function Website(string $website) : LazyPamlApi{
		$this->website = $website;
		return $this;
	}

	public function Description(string $description) : LazyPamlApi{
		$this->strDescription = $description;
		return $this;
	}

	public function Prefix(string $prefix) : LazyPamlApi{
		$this->prefix = $prefix;
		return $this;
	}

	public function Load_order($load) : LazyPamlApi{
		if($load === PluginLoadOrder::POSTWORLD){
			$this->load = "POSTWORLD";
		}elseif($load === PluginLoadOrder::STARTUP){
			$this->load = "STARTUP";
		}else{
			$this->load = $load;
		}
		return $this;
	}

	public function Author(string ...$authors) : LazyPamlApi{
		foreach($authors as $author){
			$this->authors[] = $author;
		}
		return $this;
	}

	public function Authors(string ...$authors) : LazyPamlApi{
		foreach($authors as $author){
			$this->authors[] = $author;
		}
		return $this;
	}

	###########
	# API END #
	###########
	public function __construct(){
		$this->Permissions = new PermissionLoader($this);
	}

	public function getName() : string{
		return $this->name;
	}

	public function getVersion() : string{
		return $this->version;
	}

	public function getApi() : int{
		return $this->api;
	}

	public function getDescription(LazyPaml $main = null){
		if(!isset($this->description)){
			if(!isset($this->name, $this->version, $this->api)){
				return null;
			}
			assert($main !== null);
			$manifest = [
				"name" => $this->name,
				"version" => $this->version,
				"api" => $main->getServer()->getApiVersion(),
				"main" => LazyPamlChildPlugin::class,
				"commands" => [],
				"depend" => LazyPaml::getNameStatic(),
				"softdepend" => $this->softDepend,
				"loadbefore" => $this->loadBefore,
				"website" => $this->website,
				"description" => $this->strDescription,
				"prefix" => $this->prefix,
				"load" => $this->load,
				"author" => $this->author,
				"authors" => $this->authors,
				"permissions" => $this->permissionsArray,
			];
			echo yaml_emit($manifest);
			$desc = new PluginDescription($manifest);

			return $this->description = $desc;
		}
		return $this->description;
	}

	public function loadPlugin(LazyPaml $main){
		$plugin = new LazyPamlChildPlugin($main, $this);
		return $plugin;
	}

	public function registerPermissions(){
		$this->permissionsArray = $this->Permissions->toArray();
	}
}
