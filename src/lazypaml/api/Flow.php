<?php

namespace lazypaml\api;

use lazypaml\FPlugin;
use pocketmine\command\PluginCommand;

define("perm_true", "lazypaml.true", true);
define("perm_false", "lazypaml.false", true);
define("perm_op", "lazypaml.op", true);
define("perm_notop", "lazypaml.notop", true);

class Flow{
	private $plugin;
	public function __construct(FPlugin $plugin){
		$this->plugin = $plugin;
	}
	public function command($name, $perm, $description = "", $usage = null){
		$cmd = new PluginCommand($name, $this->plugin);
		$dispatcher = new FlowingCommandExecutor($this->plugin, $cmd);
		$cmd->setDescription($description);
		$cmd->setUsage($usage);
		$cmd->setPermission($perm);
		$cmd->setExecutor($dispatcher);
		return $dispatcher;
	}
}
