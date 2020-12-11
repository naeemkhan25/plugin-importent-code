<?php

/*
Plugin Name:Dashboard widgets
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:dashboard-widgets
*/

function plugin_load_dashboard_widgets(){
load_plugin_textdomain("dashboard-widgets",false,plugin_dir_path(__FILE__)."/languages");
}
add_action("plugin_loaded","plugin_load_dashboard_widgets");

function dashboard_widgets_setup(){
    if(current_user_can("edit_dashboard")) {
        wp_add_dashboard_widget("dashboard_widgetsId",
            'dashboard Widgets',
            "dashboard_widgets_output_callback",
            "dashboard_widgets_configuration");
    }else{
        wp_add_dashboard_widget("dashboard_widgetsId",
            'dashboard Widgets',
            "dashboard_widgets_output_callback");
    }
}
add_action("wp_dashboard_setup",'dashboard_widgets_setup');

function dashboard_widgets_output_callback(){
    //wp_dashboard e bildin onek kisu dekha jabe
    $feed=array(
        array(
            'url'=>'https://wptavern.com/feed',
            'items'=>get_option("dashboard_widgets",5),
            'show_summary'=>0,
            'show_author'=>1,
            'show_date'=>1
        )
    );
    wp_dashboard_primary_output('dashboard_widgetsId',$feed);
}
function dashboard_widgets_configuration(){
    $number_of_post=get_option("dashboard_widgets",5);
    if(isset($_POST['dashboard-widget-nonce'])&&wp_verify_nonce($_POST['dashboard-widget-nonce'],"edit-dashboard-widget_dashboard_widgetsId")) {
        if (isset($_POST['dashboard_items']) && $_POST['dashboard_items'] > 0) {
            $number_off_pos = sanitize_text_field($_POST['dashboard_items']);
            update_option("dashboard_widgets", $number_off_pos);
        }
    }
   ?>
    <label for="dashboard_items">Add items</label>
    <input type="text" name="dashboard_items" value="<?php echo $number_of_post ?>">

<?php
}