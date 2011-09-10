<?php

require_once PATH_THIRD.'recognize/config'.EXT;

class Recognize_mcp {

	public function __construct()
	{
		$this->EE =& get_instance();
		$this->EE->load->helper('recognize');
		
		$this->EE->cp->set_variable('cp_page_title', RE_SHORT_NAME);
		$this->EE->cp->set_breadcrumb(re_cp_url(), RE_SHORT_NAME);
	}
	
	public function index()
	{
		$this->EE->cp->set_right_nav(array(
			'add_app' => re_cp_url('add_app')
		));
		
		$apps = $this->EE->db->get('exp_recognize_apps');
		
		if ($apps->num_rows)
		{
			return $this->EE->load->view('list', array('apps'=>$apps->result()), TRUE);
		}
		
		return $this->EE->load->view('welcome', array(), TRUE);
	}
	
	public function add_app()
	{
		$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('add_app').' - '.RE_SHORT_NAME);
		return $this->EE->load->view('add', array(), TRUE);
	}
	
	public function post_app()
	{
		$this->EE->db->insert('exp_recognize_apps', array(
			'app_name' => $this->EE->input->post('app_name'),
			'app_id' => $this->EE->functions->random('alnum', 8),
			'app_secret' => $this->EE->functions->random('sha1', 32),
			'callback_url' => $this->EE->input->post('callback_url')
		));
		
		$this->EE->functions->redirect(re_cp_url());
	}
	
	public function delete_app()
	{
		$this->EE->db->delete('exp_recognize_apps', array(
			'id' => $this->EE->input->get('app_id')
		));
		
		$this->EE->functions->redirect(re_cp_url());
	}
}