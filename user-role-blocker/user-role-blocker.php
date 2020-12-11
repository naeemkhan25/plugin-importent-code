<?php
/*
Plugin Name:User Role blocker
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:user-role-blocker
*/
use HasinHayder\D\D;
add_action("init",function () {
    add_role("blocker", __("blocker", "user-role-blocker"), array("blocked" => true));
    add_rewrite_rule("blocked/?$", "index.php?blocked=1", "top");
        });
add_action("init",function (){
//    $user=wp_get_current_user();
//    D::print_r($user);
    if(is_admin() && current_user_can("blocked")){
        wp_redirect(get_home_url().'/blocked');

        die();
    }
});
//aita use kore hoy rerite url k wordpress er kase patanor jonno.
add_filter("query_vars",function ($query_vars){
    $query_vars[]="blocked";
//    D::print_r($query_vars);
    return $query_vars;
});



add_action("template_redirect",function (){
    $is_blocked=intval(get_query_var("blocked"));
    if($is_blocked){
       echo "hallo i am blocked user";
        die();
    }
});



add_action("wp_footer",function (){

    D::dumpInConsole();
});