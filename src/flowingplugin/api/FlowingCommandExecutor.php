<?php

namespace flowingplugin\api;

use flowingplugin\FPlugin;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;

class FlowingCommandExecutor implements CommandExecutor{
	private $plugin;
	private $args = [];
	private $startedOptional = false;
	private $infiniteArgs = false;
	/** @var FlowingCommandRunner */
	private $runner = null;
	private $cmd;
	public function __construct(FPlugin $plugin, PluginCommand $cmd){
		$this->plugin = $plugin;
		$this->cmd = $cmd;
	}
	public function argument($name, $default = null, $infinite = false){
		if($this->infiniteArgs){
			throw new \RuntimeException("Cannot add arguments after the infinite argument!");
		}
		if($this->startedOptional and $default === null){
			throw new \RuntimeException("Cannot add non-optional arguments after optional arguments!");
		}
		$this->args[] = ["name" => $name, "default" => $default];
		if($default !== null){
			$this->startedOptional = true;
		}
		if($infinite){
			$this->infiniteArgs = true;
		}
		return $this;
	}
	public function onRun(){
		if($this->runner === null){
			$this->runner = new FlowingCommandRunner($this);
		}
		return $this->runner;
	}
	public function onCommandFlowed(){
		$this->plugin->registerCommand($this->cmd);
		return $this;
	}
	public function onCommand(CommandSender $sender, Command $cmd, $alias, array $args){
		/** @var \pocketmine\command\PluginCommand $cmd */
		$max = count($this->args) - 1;
		$assoc = [];
		for($i = 0; $i < count($this->args); $i++){
			$arg = $this->args[$i];
			$name = $arg["name"];
			if(isset($args[0])){
				if($i === $max and $this->infiniteArgs){
					$assoc[$name] = implode(" ", $args);
				}
				else{
					$assoc[$name] = array_shift($args);
				}
			}
			elseif($arg["default"] !== null){
				$assoc[$name] = $arg["default"];
			}
			else{
				$sender->sendMessage("Usage: " . $cmd->getUsage());
				return;
			}
		}
		$this->runner->run($assoc);
	}
	public function getPlugin(){
		return $this->plugin;
	}
}
