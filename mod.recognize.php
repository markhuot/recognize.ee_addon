<?php

require_once PATH_THIRD.'recognize/config'.EXT;

class Recognize
{
	
	public function __construct()
	{
		$this->EE =& get_instance();
		$this->EE->load->helper('recognize');
		$this->EE->load->model('recognize_model', 'recognize');
	}
	
	public function login()
	{
		$this->_check_input();
		$this->_check_app();
		
		if ($this->EE->session->userdata('member_id'))
		{
			$url = act_url(RE_SHORT_NAME, 'allow', $_GET);
			$this->EE->functions->redirect($url);
		}
		
		$view = $this->EE->load->view('login', array(), TRUE);
		$view = $this->EE->functions->add_form_security_hash($view);
		$view = $this->EE->functions->insert_action_ids($view);
		$this->EE->output->append_output($view);
	}
	
	public function post_login()
	{
		$this->_check_input();
		$this->_check_app();
		
		$this->EE->load->library('auth');
		
		$username = $this->EE->input->post('username');
		$password = $this->EE->input->post('password');
		
		$member = $this->EE->auth->authenticate_username($username, $password);
		$member->start_session(TRUE);
		
		$url = act_url(RE_SHORT_NAME, 'allow', $_GET);
		$this->EE->functions->redirect($url);
	}
	
	public function allow()
	{
		$this->_check_input();
		$this->_check_app();
		$this->_check_login();
		
		$this->EE->load->view('allow');
	}
	
	public function post_allow()
	{
		$this->_check_input();
		$this->_check_app();
		$this->_check_login();
		
		$client_id = $this->EE->input->get('client_id');
		$result = $this->EE->recognize->generate_code($client_id, 'code');
		
		$url = act_url(RE_SHORT_NAME, 'redirect_uri', array(
			'code' => $result->code,
			'state' => $this->EE->input->get('state')
		));
		$this->EE->functions->redirect($url);
	}
	
	public function redirect_uri()
	{
		
	}
	
	/**
	 * Checks that a valid response_type is set.
	 * http://tools.ietf.org/html/draft-ietf-oauth-v2-22#section-4.1.1
	 */
	private function _check_input()
	{
		if ($this->EE->input->get('response_type') !== 'code')
		{
			show_error(l('bad_response_type'));
		}
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