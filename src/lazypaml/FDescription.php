<?php

namespace lazypaml;

use pocketmine\plugin\PluginDescription;
use pocketmine\plugin\PluginLoadOrder;

class FDescription extends PluginDescription{
	private $main;
	private $data;
	public function __construct(Registrator $main, $src){
		$this->main = $main;
		if(!preg_match_all("/__LazyPaml__[\r\n]+([a-zA-Z0-9_\-)=.+[\r\n]+)+/m", $src, $matches)){
			throw new \RuntimeException("Cannot find description");
		}
		$properties = preg_split("/[\r\n]+/m", $matches[1][0]);
		$data = [];
		foreach($properties as $line){
			list($key, $value) = explode("=", $line, 2);
			$data[strtolower($key)] = $value;
		}
		foreach(["name", "version", "entry", "api"] as $need){
			if(!isset($data[$need])){
				throw new \RuntimeException("Needed property '$need' missing");
			}
		}
		$this->data = $data;
	}
	public function getFullName(){
		return sprintf("%s v%s", $this->getName(), $this->getVersion());
	}
	public function getCompatibleApis(){
		return $this->main->getDescription()->getCompatibleApis();
	}
	public function getAuthors(){
		$authors = [];
		if(isset($this->data["author"])){
			$authors[] = $this->data["author"];
		}
		if(isset($this->data["authors"])){
			$authors = array_merge($authors, explode(",", $this->data["authors"]));
		}
		return $authors;
	}
	public function getPrefix(){
		return isset($this->data["prefix"]) ? $this->data["prefix"]:$this->getName();
	}
	public function getCommands(){
		return [];
	}
	public function getDepend(){
		return isset($this->data["dependencies"]) ? explode(",", $this->data["dependencies"]):[];
	}
	public function getDescription(){
		return isset($this->data["description"]) ? $this->data["description"]:null;
	}
	public function getLoadBefore(){
		return isset($this->data["load_before"]) ? explode(",", $this->data["load_before"]):[];
	}
	public function getMain(){
		return "lazypaml\\FPlugin";
	}
	public function getOrder(){
		$str = isset($this->data["load"]) ? $this->data["load"]:"POSTWORLD";
		return defined($path = PluginLoadOrder::class . $str) ? constant($path):PluginLoadOrder::POSTWORLD;
	}
	public function getPermissions(){
		return [];
	}
	public function getSoftDepend(){
		return isset($this->data["soft_dependencies"]) ? explode(",", $this->data["soft_dependencies"]):[];
	}
	public function getName(){
		return $this->data["name"];
	}
	public function getVersion(){
		return $this->data["version"];
	}
	public function getWebsite(){
		return $this->data["website"];
	}
	public function getEntryPoint(){
		return $this->data["entry"];
	}
	public function getFApi(){
		return $this->data["api"];
	}
}
