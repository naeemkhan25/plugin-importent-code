<?php
/*
Plugin Name:admin Notice
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:admin_notice
Domain Path:/languages/
*/
function admin_notice_for_plugin(){
    //global e file gulo dekha jabe.ami ekhon kon folder e achi tar theme.php index.php ei gulo
    global $pagenow;

    if(!(isset($_COOKIE['nn-close'])&& $_COOKIE['nn-close']==1)){
        if($pagenow=="plugins.php"){

    ?>
    <div id="notice_ninja" class="notice notice-success is-dismissible">
        <p>
            your plugin active successfully!
        </p>
    </div>
<?php
        }
}
}

add_action("admin_notices","admin_notice_for_plugin");

function admin_notice_assets_load(){
    wp_enqueue_script("admin-notice-js",plugin_dir_url(__FILE__)."/assets/js/notice.js",array('jquery'),time(),true);

}
add_action("admin_enqueue_scripts","admin_notice_assets_load");
