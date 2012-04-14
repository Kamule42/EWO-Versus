<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if ( ! function_exists('anchor_intern'))
{
	function anchor_intern($uri, $title = '', $attributes = '')
	{
		$title = (string) $title;

		if ( ! is_array($uri))
		{
			$site_url = ( ! preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
		}
		else
		{
			$site_url = site_url($uri);
		}

		if ($title == '')
		{
			$title = $site_url;
		}

		if ($attributes != '')
		{
			$attributes = _parse_attributes($attributes);
		}

		return 
        '<a href="'.$site_url.'" onclick="anchor_intenr(\''.$site_url.'\');return false;" '.$attributes.'>'.$title.'</a>';
	}
}
?>
