<?php

/*
 * LazyPaml
 *
 * Copyright (C) 2016 PEMapModder
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PEMapModder
 */

namespace LazyPaml\API\Permission;

interface PermissionEntryParent{
	public function Name(string $name) : PermissionEntry;

	public function Description(string $description) : PermissionEntry;

	public function Default_targets(string $default) : PermissionEntry;
}
