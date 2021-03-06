<?php
/*
Plugin Name:Post tax Meta Field
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:post-Tax-Meta
*/

function post_tax_meta_plugin_load(){
    load_plugin_textdomain("post-Tax-Meta",false,dirname(__FILE__)."/languages/");
}
add_action("plugin_loaded","post_tax_meta_plugin_load");
function post_tax_meta_assets(){
    wp_enqueue_style("bootstrap",'//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
}
add_action("wp_enqueue_scripts",'post_tax_meta_assets');

function post_select_metaBox(){
    add_meta_box("_post_select_metabox",
        __("Select Metabox","post-Tax-Meta"),
        "post_select_metaBox_in_page",
        array('page'),
    'normal',
    'default'
    );
}
add_action("admin_menu","post_select_metaBox");
function save_select_post($post_id){
    if(!is_security('nonce_post_select','nonce_select_post',$post_id)){
        return $post_id;
    }
    $select_post=$_POST['post'];
    if($select_post>0){
        update_post_meta($post_id,'select_post_meta',$select_post);
    }
    return $post_id;

}
add_action("save_post","save_select_post");
if(!function_exists("is_security")) {
    function is_security($noncename, $nonceaction, $postID)
    {
        $nonce = isset($_POST[$noncename]) ? $_POST[$noncename] : '';
        if ($nonce == '') {
            return false;
        }
        if (!wp_verify_nonce($nonce, $nonceaction)) {
            return false;
        }
        if (!current_user_can("edit_post", $postID)) {
            return false;
        }
        if (wp_is_post_autosave($postID)) {

            return false;
        }
        if (wp_is_post_revision($postID)) {
            return false;
        }
        return true;
    }
}
function post_select_metaBox_in_page($post){
    wp_nonce_field("nonce_select_post",'nonce_post_select');
$post_meta_id=get_post_meta($post->ID,'select_post_meta',true);

//echo $post_meta_id;
    $select_one='';
    if($post_meta_id==0){
        $select_one='selected';
    }
echo "</br>";
    $arrgs=array(
      'post_type'=>'post',
      'post_per_pages'=>-1,
    );
    $metaoption='';
    $_post=new WP_Query($arrgs);
    while ($_post->have_posts()){
        $selected_post='';
        $_post->the_post();
        if($post_meta_id==get_the_ID()){
            $selected_post='selected';
        }

        $metaoption.=sprintf('<option %s value="%s">%s</option>',$selected_post,get_the_ID(),get_the_title());

    }
    wp_reset_query();

    $label=__("Choose a post",'post-Tax-Meta');
    $option=__("Select One",'post-Tax-Meta');
$metabox=<<<EOD
 <label for="post_meta">{$label}</label>
<select id="post_meta" class="form-control" name="post">
  <option {$select_one} value="0">{$option}</option>
  {$metaoption}

</select> 
EOD;
echo $metabox;
}
