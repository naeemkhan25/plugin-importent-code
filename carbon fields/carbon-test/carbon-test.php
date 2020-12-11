<?php

/*
Plugin Name:Carbon Test
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:carbon-test
*/

use Carbon_Fields\Container;
use Carbon_Fields\Field;
require_once "vendor/autoload.php";
function carbon_fields_boot(){
    \Carbon_Fields\Carbon_Fields::boot();
}
add_action("plugin_loaded","carbon_fields_boot");
function carbon_fields_metaBox(){
    Container::make( 'post_meta', __( 'carbon Metabox',"carbon-test" ) )
        ->where( 'post_type', '=', 'page' )
        ->set_context( 'normal' )
        ->set_priority( 'default')
        ->add_fields( array(
            Field::make( 'text', 'crb_text', 'First Name'),
            Field::make( 'text', 'crb_text2', 'Last name')
        ) );
}
add_action("carbon_fields_register_fields","carbon_fields_metaBox");