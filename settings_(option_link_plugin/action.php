<?php
function plugins_settings_links($links){
	$link=sprintf('<a href="%s">%s</a>','options-general.php?page=(slug)->amader ta)optiondemo,__("settings",optiondmeo");
	$links[]=$link;
return $links;	
}
add_filter("plugins_action_links_".plugin_basename(__FILE__),"plugins_settings_links")