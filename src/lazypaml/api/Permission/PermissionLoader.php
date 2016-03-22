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

use LazyPaml\API\LazyPamlApi;

class PermissionLoader implements PermissionEntryParent{
	/** @var LazyPamlApi|PermissionEntry $Thats_all */
	public $Thats_all;

	/** @var PermissionEntry[] $done */
	private $done = [];

	/** @var PermissionEntry $current */
	private $current;

	/**
	 * PermissionLoader constructor.
	 *
	 * @param LazyPamlApi|PermissionEntry $api
	 */
	public function __construct($api){
		$this->Thats_all = $api;
		$this->current = new PermissionEntry($this);
	}

	/**
	 * @param string $name
	 *
	 * @return PermissionEntry
	 */
	public function Name(string $name) : PermissionEntry{
		return $this->current->Name($name);
	}

	public function Description(string $description) : PermissionEntry{
		return $this->current->Description($description);
	}

	public function Default_targets(string $default) : PermissionEntry{
		return $this->current->Default_targets($default);
	}

	public function __get($k){
		if($k === "Thats_all" and $this->Thats_all instanceof LazyPamlApi){
			$this->Thats_all->registerPermissions();
		}

		return $this->{$k};
	}

	public function nextCurrent(){
		$this->done[] = $this->current;
		$this->current = new PermissionEntry($this);
	}

	/**
	 * @return PermissionEntry[]
	 */
	public function getDone() : array{
		return $this->done;
	}

	public function toArray(){
		if($this->current->hasName()){
			$this->done[] = $this->current;
		}
		$this->current = null;
		$out = [];
		foreach($this->done as $done){
			$out[$done->getName()] = $done->toArray();
		}
		return $out;
	}
}
