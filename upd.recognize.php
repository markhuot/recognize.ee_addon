<?php

require_once PATH_THIRD.'recognize/config'.EXT;

class Recognize_upd
{
	
	var $module_name = RE_SHORT_NAME;
	var $version = RE_VERSION;
	
	public function __construct() 
	{
		$this->EE =& get_instance();
	}
	
	public function install()
	{
		// install module
		$data = array(
			'module_name' => $this->module_name,
			'module_version' => $this->version,
			'has_cp_backend' => 'y',
			'has_publish_fields' => 'n'
		);
		$this->EE->db->insert('modules', $data);
		
		// insert actions
		foreach (array(
			array('class' => $this->module_name, 'method' => 'login'),
			array('class' => $this->module_name, 'method' => 'post_login'),
			array('class' => $this->module_name, 'method' => 'allow'),
			array('class' => $this->module_name, 'method' => 'post_allow'),
		) as $action)
		{
			$this->EE->db->insert('actions', $action);
		}
		
		// install extension
		foreach (array(
			'sessions_start'
		) as $hook)
		{
			$this->EE->db->insert('extensions', array(
				'class'		=> "{$this->module_name}_ext",
				'method'	=> $hook,
				'hook'		=> $hook,
				'settings'	=> '',
				'priority'	=> 10,
				'version'	=> $this->version,
				'enabled'	=> 'y'
			));
		}
		
		// create tables
		$this->EE->load->dbforge();
		$this->EE->dbforge->add_field("`id` int(11) NOT NULL AUTO_INCREMENT");
		$this->EE->dbforge->add_field("`app_name` varchar(100) NULL");
		$this->EE->dbforge->add_field("`app_id` varchar(512) NULL");
		$this->EE->dbforge->add_field("`app_secret` varchar(512) NULL");
		$this->EE->dbforge->add_key("id", TRUE);
		$this->EE->dbforge->create_table('recognize_apps');
		
		$this->EE->dbforge->add_field("`id` int(11) NOT NULL AUTO_INCREMENT");
		$this->EE->dbforge->add_field("`member_id` varchar(100) NULL");
		$this->EE->dbforge->add_field("`app_id` varchar(512) NULL");
		$this->EE->dbforge->add_field("`code` varchar(512) NULL");
		$this->EE->dbforge->add_field("`access_token` varchar(512) NULL");
		$this->EE->dbforge->add_field("`token_type` varchar(512) NULL");
		$this->EE->dbforge->add_field("`expires_at` varchar(512) NULL");
		$this->EE->dbforge->add_field("`scope` varchar(512) NULL");
		$this->EE->dbforge->add_key("id", TRUE);
		$this->EE->dbforge->create_table('recognize_auths');
		
		return TRUE;
	}
	
	public function update($current = '')
	{
		if ($current == $this->version)
		{
			return FALSE;
		}
			
		if ($current < 2.0) 
		{
			// Do your update code here
		} 
		
		return TRUE; 
	}
	
	public function uninstall()
	{
		// remove module
		$this->EE->db->where('module_name', $this->module_name);
		$this->EE->db->delete('modules');
		
		// remove actions
		$this->EE->db->where('class', $this->module_name);
		$this->EE->db->delete('actions');
		
		// remove extension
		$this->EE->db->where('class', "{$this->module_name}_ext");
		$this->EE->db->delete('extensions');
		
		// drop tables
		$this->EE->load->dbforge();
		$this->EE->dbforge->drop_table('recognize_apps');
		$this->EE->dbforge->drop_table('recognize_auths');
		
		return TRUE;
	}
	
}