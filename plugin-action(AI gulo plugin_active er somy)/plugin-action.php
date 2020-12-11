<?php
/*
Plugin Name:plugin action
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:plugin-action
*/

add_action("admin_menu",function (){
    add_menu_page(
        __("Action plugin",'plugin-action'),
        __("Action Plugin","plugin-action"),
        "manage_options",
        "action_plugins",
        function (){
           ?>
            <h4>hi  i am naeem</h4>
<?php
        }
    );
});


//activete action ta use kora hoy protiti row  ka search kora hoy .
add_action("activated_plugin",function ($plugin){
    if(plugin_basename(__FILE__)==$plugin){
        wp_redirect(admin_url("admin.php?page=action_plugins"));
        die();
    }

});

function plugins_setting_links($links){
    $link=sprintf('<a href="%s" style="color: #ff2222">%s</a>',admin_url("admin.php?page=action_plugins"),__("Setting","action-plugin"));
    array_push($links,$link);
    return $links;

}
add_filter("plugin_action_links_".plugin_basename(__FILE__),"plugins_setting_links");
//row google setting
add_filter("plugin_row_meta",function ($links,$plugin){
    if(plugin_basename(__FILE__)==$plugin){
        $link=sprintf('<a href="%s" style="color: #ff2222">%s</a>',"https://google.com",__("Google","action-plugin"));
        array_push($links,$link);

    }
    return $links;
},10,2);

