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
	
	public function sessions_end($session)
	{
		$this->EE->session = $session;
		$class = $method = FALSE;
		
		if ($this->EE->input->get('API'))
		{
			if (($class = ucfirst($this->EE->input->get('API'))) === FALSE)
			{
				return false;
			}
			
			if (($method = $this->EE->input->get('do')) === FALSE)
			{
				return false;
			}
		}
		
		else if ($this->EE->uri->segment(1) === 'api')
		{
			if (($class = ucfirst($this->EE->uri->segment(2))) === FALSE)
			{
				return false;
			}
			
			if (($method = $this->EE->uri->segment(3)) === FALSE)
			{
				return false;
			}
		}
		
		if ($class && $method)
		{
			$this->EE->load->helper('recognize');
			$this->EE->functions->redirect(act_url($class, $method, $_GET));
		}
	}
	
}