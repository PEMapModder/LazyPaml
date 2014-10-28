<?php

namespace flowingplugin\api;

use flowingplugin\FPlugin;
use pocketmine\command\PluginCommand;

define("perm_true", "flowingplugin.true", true);
define("perm_false", "flowingplugin.false", true);
define("perm_op", "flowingplugin.op", true);
define("perm_notop", "flowingplugin.notop", true);

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
