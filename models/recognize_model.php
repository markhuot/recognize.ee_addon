<?php

class Recognize_model extends CI_Model
{
	
	public function allow($client_id)
	{
		$code = 
		$access_token = 
		$token_type = 
		$expires_in = time() + (60 * 10); /* 10 minutes */
		$scope = $this->EE->input->get('scope');
		
		$this->EE->db->set('member_id', $this->EE->session->userdata('member_id'));
		$this->EE->db->set('app_id', $client_id);
		$this->EE->db->set('code', $code);
		$this->EE->db->set('access_token', $access_token);
		$this->EE->db->set('token_type', $token_type);
		$this->EE->db->set('expires_in', $expires_in);
		$this->EE->db->set('scope', $scope);
	}
	
}