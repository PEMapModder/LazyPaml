<?php

/*
__LazyPaml__
description=Example LazyPaml
name=ExamplePlugin
version=1.0
api=TODO
entry=ExamplePluginEntry
 */

// note: these three lines are not necessary.
/**
 * @param \lazypaml\api\Flow $plugin
 */
function ExamplePluginEntry($plugin){
	$plugin
		-> command("example", perm_true)
			-> argument ("argument 1")
			-> argument ("argument 2", "default")
			-> onRun()
				-> send ()
					-> line ("something")
					-> line ("something 2", true)
			-> done()
	;
}
