<?php
/*
Plugin Name:CPTUI plugin
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:CPTUI_plugin
*/
function philosophy_companion_register_my_cpts_book() {

    /**
     * Post Type: Books.
     */

    $labels = [
        "name" => __( "Books", "philosophy" ),
        "singular_name" => __( "Book", "philosophy" ),
        "menu_name" => __( "Books", "philosophy" ),
        "add_new" => __( "Add new", "philosophy" ),
        "featured_image" => __( "featured cover", "philosophy" ),
        "set_featured_image" => __( "Set featured image for this Book", "philosophy" ),
    ];

    $args = [
        "label" => __( "Books", "philosophy" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => "books",
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => [ "slug" => "note", "with_front" => false ],
        "query_var" => true,
        "supports" => [ "title", "editor", "thumbnail" ],
    ];

    register_post_type( "book", $args );
}
add_action( 'init', 'philosophy_companion_register_my_cpts_book' );
function single_template_philosophy_cptui_plugin($file){
    global $post;
    if('book'==$post->post_type){
        $file_path=plugin_dir_path(__FILE__)."/Cptui_template/single-book.php";
        $file=$file_path;
    }
    return $file;
}
add_filter("single_template","single_template_philosophy_cptui_plugin");