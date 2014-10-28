<?php

namespace flowingplugin\api;

class FlowingCommandRunner implements ResultableParent{
	/** @var FlowingCommandExecutor */
	private $parent;
	private /** @noinspection PhpUnusedPrivateFieldInspection */
		$operations = [];
	public function __construct(FlowingCommandExecutor $parent){
		$this->parent = $parent;
	}
	public function send(){
		return new ResultableString($this);
	}
	public function done(){
		$this->parent->onCommandFlowed();
	}
	public function onResulted(Resultable $result){
		// TODO: Implement onResulted() method.
	}
	/**
	 * @param array $args an associative array of arguments
	 */
	public function run(array $args){
		// TODO: Implement run() method.
	}
}
