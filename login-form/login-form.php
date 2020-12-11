<?php
/*
Plugin Name: Login Form
Plugin URI:
Description: Friendly Description
Version: 1.0.0
Author: LWHH
Author URI:
License: GPLv2 or later
Text Domain: login-form
 */
function lof_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo plugin_dir_url(__FILE__)."assets/images/wplogo.png";?>);
            height:100px;
            width:100px;
            background-size:100px;
            background-repeat: no-repeat;

        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'lof_login_logo' );

add_action("login_head",function (){
    add_filter("gettext",function ($translated_text,$text_to_translated,$textdomain){
            if("Username or Email Address"==$text_to_translated){
                $translated_text=__("your Login key","login-form");
            }elseif("Password"==$text_to_translated){
                $translated_text=__("pass key","login-form");
            }
            //ai vabe sob gulo string k change korthe parbo
        return $translated_text;
    },10,3);
});
function lof_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'lof_login_logo_url' );

function lof_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter( 'login_headertitle', 'lof_login_logo_url_title' );
function lf_login_stylesheet() {
    wp_enqueue_style( 'custom-login-css', plugin_dir_url(__FILE__) . 'assets/css/style-login.css');
    wp_enqueue_script( 'custom-login-jss', plugin_dir_url(__FILE__) . 'assets/js/style-login.js',array("jquery"),time(),true);
}
add_action( 'login_enqueue_scripts', 'lf_login_stylesheet' );
