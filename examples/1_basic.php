<?php

// Note:
// lines starting with # or //, or things inside /* */ are only comments to explain things
// so a human should read these lines if he understands, or ignore them otherwise
//@formatter:off

# you must not forget this namespace line!
namespace LazyPaml\API;

# This is not needed in real LazyPaml plugins
/* @var LazyPamlApi $LazyPaml */

$LazyPaml
	-> Name    ("1_basic")
	-> Version ("1.0.0")     # This version name is entirely internal. This will only be seen on console.
	-> API     (ApiVersion::Helium)
	-> Author  ("PEMapModder")
	-> Permissions
		-> Name ("basic")
			-> Description     ("Root permission node of 1_basic")
			-> Default_targets ("true")
			-> Children
				-> Name ("basic.child")
					-> Description ("Child permission")
					-> Done
			-> Thats_all
		-> Done
	-> Thats_all
;


// (no need to copy the following line)
//@formatter:on
