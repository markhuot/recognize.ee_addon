<?php

class Recognize_model extends CI_Model
{
	
	public function generate_code($client_id, $type)
	{
		$type = 'code';
		$code = $this->functions->random('sha1', 54);
		$expires_in = 60 * 10; /* 10 minutes */
		$expires_at = time() + $expires_in;
		$scope = $this->input->get('scope');
		
		$this->db->set('member_id', $this->session->userdata('member_id'));
		$this->db->set('app_id', $client_id);
		$this->db->set('type', $type);
		$this->db->set('code', $code);
		$this->db->set('expires_at', $expires_at);
		$this->db->set('scope', $scope);
		$this->db->insert('exp_recognize_auths');
		
		return (object)array(
			'code' => $code,
			'expires_in' => $expires_in
		);
	}
	
}