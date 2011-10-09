<?php

require_once PATH_THIRD.'recognize/config'.EXT;

class Recognize_api
{
	
	public function __construct()
	{
		$this->EE =& get_instance();
		$this->EE->load->helper('recognize');
		$this->EE->load->model('recognize_model', 'recognize');
	}
	
	public function authorize()
	{
		if ($this->EE->session->userdata('member_id') == FALSE)
		{
			$url = api_url(RE_SHORT_NAME, 'login', $_GET);
			$this->EE->functions->redirect($url);
		}
		
		else
		{
			$url = api_url(RE_SHORT_NAME, 'allow', $_GET);
			$this->EE->functions->redirect($url);
		}
	}
	
	public function login()
	{
		$this->_check_app($this->EE->input->get('client_id'));
		
		if ($this->EE->session->userdata('member_id'))
		{
			$url = api_url(RE_SHORT_NAME, 'allow', $_GET);
			$this->EE->functions->redirect($url);
		}
		
		$this->EE->load->view('login');
	}
	
	public function post_login()
	{
		$this->_check_app($this->EE->input->get('client_id'));
		
		$this->EE->load->library('auth');
		
		$username = $this->EE->input->post('username');
		$password = $this->EE->input->post('password');
		
		$member = $this->EE->auth->authenticate_username($username, $password);
		$member->start_session(FALSE);
		
		$url = api_url(RE_SHORT_NAME, 'allow', $_GET);
		$this->EE->functions->redirect($url);
	}
	
	public function allow()
	{
		$this->_check_input(array(
			'response_type' => 'code'
		));
		$this->_check_app($this->EE->input->get('client_id'));
		$this->_check_login();
		
		$this->EE->load->view('allow');
	}
	
	public function post_allow()
	{
		$this->_check_input(array(
			'response_type' => 'code'
		));
		$this->_check_app($this->EE->input->get('client_id'));
		$this->_check_login();
		
		$client_id = $this->EE->input->get('client_id');
		$result = $this->EE->recognize->generate_code($client_id, 'authorization');
		
		$url = api_url(RE_SHORT_NAME, 'redirect_uri', array(
			'code' => $result->code,
			'state' => $this->EE->input->get('state')
		));
		$this->EE->functions->redirect($url);
	}
	
	public function redirect_uri()
	{
		
	}
	
	public function token()
	{
		$client_id = $this->EE->input->post('client_id');
		$client_secret = $this->EE->input->post('client_secret');
		
		$this->_check_input(array(
			'grant_type' => 'authorization_code'
		));
		$this->_check_app($client_id, $client_secret);
		
		$access_token = $this->EE->recognize->generate_code($client_id, 'access_token');
		$refresh_token = $this->EE->recognize->generate_code($client_id, 'refresh_token');
		
		return array(
			'access_token' => $access_token->code,
			'token_type' => 'bearer',
			'expires_in' => $access_token->expires_in,
			'refresh_token' => $refresh_token->code
		);
	}
	
	/**
	 * Checks that a valid response_type is set.
	 * http://tools.ietf.org/html/draft-ietf-oauth-v2-22#section-4.1.1
	 */
	private function _check_input($check, $strict=TRUE)
	{
		foreach ($check as $key => $value)
		{
			if ($this->EE->input->get_post($key) !== $value)
			{
				show_error(l('bad_input', $key.' = '.$this->EE->input->get_post($key)));
			}
		}
	}
	
	private function _check_login()
	{
		if ($this->EE->session->userdata('member_id') == FALSE)
		{
			$url = api_url(RE_SHORT_NAME, 'login', $_GET);
			$this->EE->functions->redirect($url);
		}
	}
	
	private function _check_app($client_id, $client_secret=FALSE)
	{
		$this->EE->db->where('app_id', $client_id);
		
		if ($client_secret !== FALSE)
		{
			$this->EE->db->where('app_secret', $client_secret);
		}
		
		$app = $this->EE->db->get('exp_recognize_apps');
		
		if ($app->num_rows === 0)
		{
			show_error(l('no_app'));
		}
	}
	
}