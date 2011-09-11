<?php

require_once PATH_THIRD.'recognize/config'.EXT;

class Recognize
{
	
	public function __construct()
	{
		$this->EE =& get_instance();
		$this->EE->load->helper('recognize');
	}
	
	public function login()
	{
		$this->_check_app();
		
		if ($this->EE->session->userdata('member_id'))
		{
			$url = act_url(RE_SHORT_NAME, 'allow_app', $_GET);
			$this->EE->functions->redirect($url);
		}
		
		$view = $this->EE->load->view('login', array(), TRUE);
		$view = $this->EE->functions->add_form_security_hash($view);
		$view = $this->EE->functions->insert_action_ids($view);
		$this->EE->output->append_output($view);
	}
	
	public function post_login()
	{
		$this->EE->load->library('auth');
		
		$username = $this->EE->input->post('username');
		$password = $this->EE->input->post('password');
		
		$member = $this->EE->auth->authenticate_username($username, $password);
		$member->start_session(TRUE);
		
		unset($_POST['username']);
		unset($_POST['password']);
		$url = act_url(RE_SHORT_NAME, 'allow_app', $_POST);
		$this->EE->functions->redirect($url);
	}
	
	public function allow_app()
	{
		$this->_check_app();
		$this->_check_login();
	}
	
	private function _check_login()
	{
		if ($this->EE->session->userdata('member_id') == FALSE)
		{
			$url = act_url(RE_SHORT_NAME, 'login', $_GET);
			$this->EE->functions->redirect($url);
		}
	}
	
	private function _check_app()
	{
		$client_id = $this->EE->input->get('client_id');
		$this->EE->db->where('app_id', $client_id);
		$app = $this->EE->db->get('exp_recognize_apps');
		
		if ($app->num_rows === 0)
		{
			show_error(l('no_app'));
		}
	}
	
}