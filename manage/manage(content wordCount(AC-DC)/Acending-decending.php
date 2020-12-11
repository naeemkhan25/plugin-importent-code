<?php

function managePL_plugin_load(){
    load_plugin_textdomain("manage-post-list",false,dirname(__FILE__)."/languages");
}
add_action("plugin_loaded",'managePL_plugin_load');
//sobe columns er modde aarray hisabe ase;

function manage_post_columns($columns){


   
    $columns['wordCount']="word Count";
    return $columns;
}
add_filter("manage_posts_columns",'manage_post_columns');
//add_filter("manage_book_posts_columns",'manage_post_columns');
//
//function manage_category($cat_columns){
//    $cat_columns['cat_image_thumb'] = 'Image';
//    return $cat_columns;
//}
//add_filter("manage_category_columns","manage_category",10,2);

//same procehes category_pages er kheter
//add_filter("manage_pages_columns",'manage_post_columns');
//add_filter("manage__custom_column");
 
function manage_add_post_columns_value($columns,$postID){
    //ekhane $columns toiri kora array er key ta patay.
//    print_r($columns);
   if ("wordCount"==$columns){
       $word=get_post_meta($postID,'wordDataCount',true);
       echo $word;
    }

}
add_action("manage_posts_custom_column","manage_add_post_columns_value",10,2);
//add_action("manage_pages_custom_column","manage_add_post_columns_value",10,2);

//add_action("manage_book_posts_custom_column",'manage_add_post_columns_value',10,2);
//aita short kore clickable kore
//word count title ta link up korar jonno use hobe.
function manage_edit_columns($columns){
    $columns['wordCount']='wordn';
    return $columns;

}
add_filter("manage_edit-post_sortable_columns","manage_edit_columns");
//jai data gulo age save ache sei gulo ekbar meta the towri korlM.
//post gulo meta hisabe set korbo.then pore tule niye asbo
//function manage_post_meta_save_data(){
//    $_Post=get_posts(array(
//        'posts_per_page'=>-1,
//        'post_type'=>'post',
//        'post_status'=>'any'
//    ));
//   foreach ($_Post as $post){
//       $content=$post->post_content;
//       $wordcount=str_word_count(strip_tags($content));
//       update_post_meta($post->ID,"wordDataCount",$wordcount);
//   }
//}
//
//add_action("init","manage_post_meta_save_data");
function manage_post_sorted($wpquery){
    if(!is_admin()){
        return;
    }
    $orderby=$wpquery->get('orderby');
    if('wordn'==$orderby){
        $wpquery->set('meta_key',"wordDataCount");
        $wpquery->set("orderby",'meta_value_num');
    }


}
add_action("pre_get_posts","manage_post_sorted");
//new data dukle aita run korbe
function post_to_meta_convart_update($post_id){
    $post=get_post($post_id);
    $content=$post->post_content;
    $wordcount=str_word_count(strip_tags($content));
    update_post_meta($post->ID,"wordDataCount",$wordcount);
}
add_action("save_post","post_to_meta_convart_update");