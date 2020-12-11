<?php
/*
Plugin Name:Media widgets
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:media-widgets
*/
require_once plugin_dir_path(__FILE__)."/class/class.media.php";
function plugin_load_media_widgets(){
    load_plugin_textdomain("media-widgets",false,plugin_dir_path(__FILE__)."/languages");
}
add_action("plugin_loaded","plugin_load_media_widgets");

function register_media_widgets(){
    register_widget('MediaWidgets');
}
add_action("widgets_init","register_media_widgets");
function media_widgets_assets($screen){
    if($screen=="widgets.php"){
        wp_enqueue_media();
        wp_enqueue_script("media-js",plugin_dir_url(__FILE__)."/assets/admin/media.js",array("jquery"),time(),true);
    }
}
add_action("admin_enqueue_scripts","media_widgets_assets");

