<?php

require_once PATH_THIRD.'recognize/config'.EXT;

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