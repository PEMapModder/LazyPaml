<?php

namespace flowingplugin\api;

interface ResultableParent{
	public function onResulted(Resultable $result);
	/**
	 * @return Flow
	 */
	public function done();
}
