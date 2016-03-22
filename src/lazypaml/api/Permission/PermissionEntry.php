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

class PermissionEntry implements PermissionEntryParent{
	private $name;
	private $desc = "";
	private $default = "op";

	/** @var PermissionLoader $Done */
	public $Done;
	/** @var PermissionLoader $Children */
	public $Children;

	public function __construct(PermissionLoader $parent){
		$this->Done = $parent;
		$this->Children = new PermissionLoader($this);
	}

	/**
	 * @param string $name
	 *
	 * @return PermissionEntry
	 */
	public function Name(string $name) : PermissionEntry{
		$this->name = $name;
		return $this;
	}

	/**
	 * @param string $description
	 *
	 * @return PermissionEntry
	 */
	public function Description(string $description) : PermissionEntry{
		$this->desc = $description;
		return $this;
	}

	/**
	 * @param string $default
	 *
	 * @return PermissionEntry
	 */
	public function Default_targets(string $default) : PermissionEntry{
		$this->default = $default;
	}

	public function __get($k){
		if($k === "Done"){
			$this->Done->nextCurrent();
		}

		return $this->{$k};
	}

	public function hasName() : bool{
		return isset($this->name);
	}

	public function getName() : string{
		return $this->name;
	}

	public function getDesc() : string{
		return $this->desc;
	}

	public function getDefault() : string{
		return $this->default;
	}

	public function toArray(){
		return [
			"name" => $this->name,
			"description" => $this->desc,
			"default" => $this->default,
			"children" => $this->Children->toArray(),
		];
	}
}
