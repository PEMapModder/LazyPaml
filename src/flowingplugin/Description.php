<?php

namespace flowingplugin;

use pocketmine\plugin\PluginDescription;

class Description extends PluginDescription{
	public function __construct($src){
		if(!preg_match_all("/__FlowingPlugin__[\r\n]+([a-zA-Z)=.+[\r\n]+)+/m", $src, $matches)){
			throw new \RuntimeException("Cannot find description");
		}
		$properties = preg_split("/[\r\n]+/m", $matches[1][0]);
		$data = [];
		foreach($properties as $line){
			list($key, $value) = explode("=", $line, 2);
			$data[strtolower($key)] = $value;
		}
		foreach(["name", "version", "function", "api"] as $need){
			if(!isset($data[$need])){
				throw new \RuntimeException("Needed property '$need' missing");
			}
		}
	}
	public function getName(){
		return $this->data["name"];
	}
	public function getVersion(){
		return $this->data["version"];
	}
	// TODO continue
}
