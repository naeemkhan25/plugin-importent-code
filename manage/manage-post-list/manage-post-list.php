<?php
/*
Plugin Name:manage post List
Plugin UR{I:
Description:Meal companion for meal theme.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:manage-post-list
Domain Path:/languages/
*/
function managePL_plugin_load(){
    load_plugin_textdomain("manage-post-list",false,dirname(__FILE__)."/languages");
}
add_action("plugin_loaded",'managePL_plugin_load');
//sobe columns er modde aarray hisabe ase;

function manage_post_columns($columns){
    print_r($columns);
    unset($columns['author']);
    $columns['author']='Author';
    $columns['post_id']="ID";
    $columns['thumbnails']="Post Thumbnails";
    return $columns;
}

add_filter("manage_posts_columns",'manage_post_columns');
add_filter("manage_book_posts_columns",'manage_post_columns');

//same procehes category_pages er kheter
//add_filter("manage_pages_columns",'manage_post_columns');


function manage_add_post_columns_value($columns,$postID){
    //ekhane $columns toiri kora array er key ta patay.
    if('post_id'==$columns){
        echo $postID;
    }elseif ('thumbnails'==$columns){
        echo get_the_post_thumbnail($postID,array(50,60));
    }

}
add_action("manage_posts_custom_column","manage_add_post_columns_value",10,2);
//add_action("manage_pages_custom_column","manage_add_post_columns_value",10,2);

add_action("manage_book_posts_custom_column",'manage_add_post_columns_value',10,2);