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
		if ($this->EE->uri->segment(1) !== 'api')
		{
			return false;
		}
		
		if (($class = $this->EE->uri->segment(2)) === FALSE)
		{
			return false;
		}
		
		if (($method = $this->EE->uri->segment(3)) === FALSE)
		{
			return false;
		}
		
		$this->EE->load->helper('recognize');
		$this->EE->functions->redirect(act_url($class, $method, $_GET));
	}
	
}