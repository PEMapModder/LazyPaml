<?php

/*
__FlowingPlugin__
description=Example FlowingPlugin
name=ExamplePlugin
version=1.0
api=TODO
entry=ExamplePluginEntry
 */

// note: these three lines are not necessary.
/**
 * @param \flowingplugin\api\Flow $plugin
 */
function ExamplePluginEntry($plugin){
	$plugin
		-> command("example", perm_true)
			-> argument("argument 1")
			-> argument("argument 2", "default")
			-> onRun()
				-> send()
					-> line("something")
					-> line("something 2", true)
			-> done()
	;
}
