<?php

require_once PATH_THIRD.'recognize/config'.EXT;

function api_url($class, $method, $raw_params=array())
{
	$ee =& get_instance();
	
	$params = array();
	foreach ($raw_params as $key => $value)
	{
		if (!in_array($key, array('ACT', 'API', 'do')))
		{
			$params[$key] = $value;
		}
	}
	
	$qs = ($ee->config->item('force_query_string') == 'y') ? '?' : '';
	$class = strtolower($class);
	$query = count($params)?http_build_query($params):'';
	
	return $ee->functions->fetch_site_index(0, 0)."{$qs}/api/{$class}/{$method}?{$query}";
}

function act_url($class, $method, $raw_params=array())
{
	$ee =& get_instance();
	
	$params = array();
	foreach ($raw_params as $key => $value)
	{
		if (!in_array($key, array('ACT', 'API', 'do')))
		{
			$params[$key] = $value;
		}
	}
	
	$qs = ($ee->config->item('force_query_string') == 'y') ? '' : '?';
	$query = count($params)?'&'.http_build_query($params):'';
	
	$action_id = $ee->db->where(array(
		'class' => $class,
		'method' => $method
	))->get('actions')->row('action_id');
	
	return $ee->functions->fetch_site_index(0, 0).$qs.'ACT='.$action_id.$query;
}

function re_cp_url($method='', $base=TRUE)
{
	$url = '';
	
	if ($base)
	{
		$url.= BASE.AMP;
	}
	
	$url.= 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module='.RE_SHORT_NAME;
	
	if ($method)
	{
		$url.= AMP.'method='.$method;
	}
	
	return $url;
}

function l($key)
{
	$ci =& get_instance();
	$ci->lang->load('recognize', '', FALSE, TRUE, PATH_THIRD.'recognize/');
	
	return vsprintf($ci->lang->line($key), array_slice(func_get_args(), 1));
}