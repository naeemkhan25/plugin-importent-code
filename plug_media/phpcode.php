<?php

class OurMetaBox{
 public function __construct()
{
    
    add_action("admin_menu",array($this,"add_metabox_in_post"));
    //data database save er jonno
    
    add_action("save_post",array($this,"save_meta_image"));
    add_action("save_post",array($this,"save_meta_gallery"));
    add_action("admin_enqueue_scripts",array($this,"pluigin_assets"));
   
  

}



    function OurMetabox_load_textdomain(){
        load_plugin_textdomain("OurMetabox",false,plugin_dir_url(__FILE__)."/languages");
    }
    function  pluigin_assets(){
        wp_enqueue_style("ourMetabox-jqueryUi","//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css");
        wp_enqueue_script("ourMetabox-main-js",plugin_dir_url(__FILE__)."/assets/admin/js/main.js",array("jquery","jquery-ui-datepicker"),time(),true);

    }



    function save_meta_gallery($postId){
        if(!$this->is_security('gallery_nonce_name','gallery_nonce_field',$postId)){
            return $postId;
        }
        $image_ids=isset($_POST['omb_image_ids'])?$_POST['omb_image_ids']:'';
        $image_urls=isset($_POST['omb_image_urls'])?$_POST['omb_image_urls']:'';
        update_post_meta($postId,'omb_image_ids',$image_ids);
        update_post_meta($postId,'omb_image_urls',$image_urls);

    }

function save_meta_image($postId){
    if(!$this->is_security('upload_image_nonce','wp_noonce_action_image',$postId)){
        return $postId;
    }
    $image_id=isset($_POST['omb_image_id'])?$_POST['omb_image_id']:'';
    $image_url=isset($_POST['omb_image_url'])?$_POST['omb_image_url']:'';
    $image_ids=isset($_POST['omb_image_ids'])?$_POST['omb_image_ids']:'';
    $image_urls=isset($_POST['omb_image_urls'])?$_POST['omb_image_urls']:'';
    update_post_meta($postId,'omb_image_id',$image_id);
    update_post_meta($postId,'omb_image_ids',$image_ids);
    update_post_meta($postId,'omb_image_urls',$image_urls);
    update_post_meta($postId,'omb_image_url',$image_url);

}


function ourMetaBOx_add_Gallery($post){
        wp_nonce_field("gallery_nonce_field","gallery_nonce_name");
        $image_ids=get_post_meta($post->ID,'omb_image_ids',true);
        $image_urls=get_post_meta($post->ID,"omb_image_urls",true);
        $metabox=<<<EOD
<div class="row">
<div class="col-1-3" style="text-align: left;">
<lable for="image_button">Upload image: </lable>
</div>
<div style="text-align: center">
<button class="button" id="ImageButtons">Upload Image</button>
<input type="hidden" name="omb_image_ids" id="omb_image_ids" value="{$image_ids}"/>
<input type="hidden" value="{$image_urls}" name="omb_image_urls" id="omb_image_urls"/>
<div id="image_containers">
</div>
</div>
</div>
EOD;
        echo $metabox;

    }

}
new OurMetaBox();
