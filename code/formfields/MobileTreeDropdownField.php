<?php

class MobileTreeDropdownField extends TreeDropdownField {
	
	private static $allowed_actions = array(
		'tree'
	);
	
	public function tree(SS_HTTPRequest $request) {
		Subsite::$force_subsite = 1;
		return parent::tree($request);
	}
}
