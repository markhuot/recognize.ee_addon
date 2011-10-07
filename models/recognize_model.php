<?php

class Recognize_model extends CI_Model
{
	
	public function allow($client_id)
	{
		$code = '';
		$access_token = '';
		$token_type = '';
		$expires_in = 60 * 10; /* 10 minutes */
		$expires_at = time() + $expires_in;
		$scope = $this->input->get('scope');
		
		$this->db->set('member_id', $this->session->userdata('member_id'));
		$this->db->set('app_id', $client_id);
		$this->db->set('code', $code);
		$this->db->set('access_token', $access_token);
		$this->db->set('token_type', $token_type);
		$this->db->set('expires_at', $expires_at);
		$this->db->set('scope', $scope);
		$this->db->insert('exp_recognize_auths');
	}
	
}