<?php
/*
Plugin Name:Widgets Demo
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:widgets_demo
*/
require_once plugin_dir_path(__FILE__)."/widgets/class.demoWidgets.php";
require_once plugin_dir_path(__FILE__)."/widgets/class.demoWidgetsUI.php";
function widgets_demo_load_plugin(){
    load_plugin_textdomain("widgets_demo",false,plugin_dir_path(__FILE__)."/languages");
}
add_action("plugin_loaded","widgets_demo_load_plugin");

function widgets_demo_register(){
    register_widget("DemoWidgets");
    register_widget("DemoWidgetsUI");
}
add_action("widgets_init","widgets_demo_register");

function demo_Widgets_ui_assets(){
    wp_enqueue_style("widgets_demo-widgets-css",plugin_dir_url(__FILE__)."/assets/css/widget.css");
}
add_action("admin_enqueue_scripts","demo_Widgets_ui_assets");