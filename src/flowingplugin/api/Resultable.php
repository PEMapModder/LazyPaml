<?php

namespace flowingplugin\api;

abstract class Resultable{
	private $parent;
	private $codes = [];
	public function __construct(ResultableParent $parent){
		$this->parent = $parent;
	}
	/**
	 * @param $code
	 * @param bool $done
	 * @return $this|ResultableParent
	 */
	public function line($code, $done = true){
		$this->codes[] = $code;
		if($done){
			return $this->done();
		}
		return $this;
	}
	private function done(){
		$this->parent->onResulted($this);
		return $this->parent;
	}
	public abstract function value(array $args);
}
