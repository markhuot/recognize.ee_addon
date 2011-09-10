<?php

require_once PATH_THIRD.'recognize/config'.EXT;

class Recognize_ext
{
	
	public $name = RE_LONG_NAME;
	public $version = RE_VERSION;
	public $description = RE_DESCRIPTION;
	public $docs_url = RE_DOCUMENTATION;
	public $settings_exist = 'n';
	public $required_by = array('Module');
	
	public function __construct()
	{
		$this->EE =& get_instance();
	}
	
	public function sessions_start()
	{
		if (@$_GET['API'] === FALSE)
		{
			return false;
		}
	}
	
}