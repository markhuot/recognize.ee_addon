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
		$format = 'json';
		
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
			if (($class = $this->EE->uri->segment(2)) === FALSE)
			{
				return false;
			}
			
			if (($method = $this->EE->uri->segment(3)) === FALSE)
			{
				return false;
			}
		}
		
		if (preg_match('/^(.*)\.(xml|json)$/', $method, $match) != FALSE)
		{
			$method = $match[1];
			$format = $match[2];
		}
		
		if ($class && $method)
		{
			$path = PATH_THIRD."/{$class}/api.{$class}".EXT;
			$class_name = ucfirst("{$class}_api");
			
			if (file_exists($path))
			{
				require_once $path;
			}
			
			if (class_exists($class_name))
			{
				$api = new $class_name;
				$result = $api->{$method}();
				
				if ($result === null)
				{
					echo $this->EE->output->final_output;
				}
				
				else
				{
					switch ($format)
					{
						case 'json':
							header('Content-type: application/json');
							echo json_encode($result);
							break;
						
						case 'xml':
							echo "<xml><error>Not Implemented</error></xml>";
							break;
					}
				}
				
				die;
			}
		}
	}
	
}