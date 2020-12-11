<?php

/*
Plugin Name:OUR METABOX
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:OurMetabox
*/
class OurMetaBox{
 public function __construct()
{
    add_action("plugin_loaded",array($this,"OurMetabox_load_textdomain"));
    //metafiled post er sathe meta add er jonno
    add_action("admin_menu",array($this,"add_metabox_in_post"));
    //data database save er jonno
    add_action("save_post",array($this,"save_meta_post"));
    add_action("save_post",array($this,"save_meta_image"));
    add_action("save_post",array($this,"save_meta_gallery"));
    add_action("admin_enqueue_scripts",array($this,"pluigin_assets"));
    //user form e data add er jonno
    add_filter("user_contactmethods",array($this,"add_metabox_in_user_extra_info"));

}


function add_metabox_in_user_extra_info($methods){
     $methods["facebook"]=__("facebook","our_meatabox");
     return $methods;
}
    function OurMetabox_load_textdomain(){
        load_plugin_textdomain("OurMetabox",false,plugin_dir_url(__FILE__)."/languages");
    }
    function  pluigin_assets(){
        wp_enqueue_style("ourMetabox-jqueryUi","//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css");
        wp_enqueue_script("ourMetabox-main-js",plugin_dir_url(__FILE__)."/assets/admin/js/main.js",array("jquery","jquery-ui-datepicker"),time(),true);

    }

private function is_security($noncename,$nonceaction,$postID){
    $nonce=isset($_POST[$noncename])?$_POST[$noncename]:'';
    if($nonce==''){
        return false;
    }
    if(!wp_verify_nonce($nonce,$nonceaction)){
        return false;
    }
    if(!current_user_can("edit_post",$postID)){
        return false;
    }
    if(wp_is_post_autosave($postID)){

        return false;
    }
    if(wp_is_post_revision($postID)){
        return false;
    }
    return true;
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

function save_meta_post($postID){
           if(!$this->is_security('meta_location','meta_nonce_action',$postID)){
               return $postID;
           }
     $location=isset($_POST["location"])?$_POST["location"]:"";
     $country=isset($_POST["country"])?$_POST["country"]:"";
     $is_fevarit=isset($_POST["is_fevarit"])?$_POST["is_fevarit"]:0;
     $countries=isset($_POST["countries"])?$_POST["countries"]:array();
     $radioCountries=isset($_POST["radioCountries"])?$_POST["radioCountries"]:0;
     $st_country=isset($_POST["st_country"])?$_POST["st_country"]:array();
     $st_date=isset($_POST["year"])?$_POST["year"]:0;




         $location=sanitize_text_field($location);
         $country=sanitize_text_field($country);
         update_post_meta($postID,"_metalocation",$location);
         update_post_meta($postID,"_metaCountry",$country);
         update_post_meta($postID,"_metafevarit",$is_fevarit);
         update_post_meta($postID,"_metacountries",$countries);
         update_post_meta($postID,"_metaradio",$radioCountries);
         update_post_meta($postID,"_st_country",$st_country);
         update_post_meta($postID,"_st_date",$st_date);


}
function add_metabox_in_post(){
     add_meta_box("_metabox_post_location",
         __("location Info","OurMetabox"),
     array($this,"ourMetaBOx_add_metabox"),
     array("post",'page'),
     "normal",
     'default'

     );
    add_meta_box("_metabox_post_image",
        __("image Upload","OurMetabox"),
        array($this,"ourMetaBOx_add_image"),
        array("post",'page')
    );
    add_meta_box("_metabox_post_Gallery",
        __("Gallery","OurMetabox"),
        array($this,"ourMetaBOx_add_Gallery"),
        array("post",'page')
    );
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
function ourMetaBOx_add_image($post){
     wp_nonce_field("wp_noonce_action_image","upload_image_nonce");
     $image_id=get_post_meta($post->ID,'omb_image_id',true);
     $image_url=get_post_meta($post->ID,"omb_image_url",true);

     $metabox=<<<EOD
<div class="row">
<div class="col-1-3" style="text-align: left;">
<lable for="image_button">Upload image: </lable>
</div>
<div style="text-align: center">
<button class="button" id="ImageButton">Upload Image</button>
<input type="hidden" name="omb_image_id" id="omb_image_id" value="{$image_id}"/>
<input type="hidden" value="{$image_url}" name="omb_image_url" id="omb_image_url"/>
<div id="image_container">
</div>
</div>
</div>



EOD;
     echo $metabox;

}



function  ourMetaBOx_add_metabox($post){
    $countries=array(
        'bangladesh',
        'india',
        'nepal',
        'japan',
        'iran',
        'pakistan'
    );
     $meta_value=get_post_meta($post->ID,"_metalocation",true);
     $meta_value2=get_post_meta($post->ID,"_metaCountry",true);
     $is_fevarit=get_post_meta($post->ID,"_metafevarit",true);
     $countriesdata=get_post_meta($post->ID,"_metacountries",true);
     $radio=get_post_meta($post->ID,"_metaradio",true);
     $_st_country=get_post_meta($post->ID,"_st_country",true);

     $_date=get_post_meta($post->ID,"_st_date",true);

     $cheked=$is_fevarit==1?'checked':'';



     wp_nonce_field("meta_nonce_action","meta_location");
     $metabox=<<<EOD

<p>
<label for="location">Add Location</label>
<input id="location" name="location" type="text" value="{$meta_value}">
</p>
<br/>
<br/>
<p>
<label for="country">Add Countries</label>
<input id="country" name="country" type="text" value="{$meta_value2}">
</p>
<br/>
<br/>
<p>
<label for="is_fevarit">is Fevarit</label>
<input id="is_fevarit" name="is_fevarit" type="checkbox" value="1" {$cheked}>
</p>

<p>
<label for=countries>Select Countries:</label>

EOD;
    $countriesdata=is_array($countriesdata)?$countriesdata:array();
     foreach ($countries as $country){
         $is_checked=in_array($country,$countriesdata)?'checked':'';
         $metabox.=<<<EOD
        <label for="country">{$country}</label>
  
        <input type="checkbox" name="countries[]" value="{$country}" {$is_checked}>

  

EOD;

     }
     $metabox.="</p>";
     $metabox.=<<<EOD
<p>
<label>Select Radio Countries:</label>
<br/>
EOD;

     foreach ($countries as $country) {
            $checked_rd=($country=="$radio")?"checked='checked'":'';
         $metabox .= <<<EOD
    <label for="radioCountries">{$country}</label>
    <input type="radio" name="radioCountries" id="radioCountries" value="{$country}" {$checked_rd}/>
    
EOD;
     }
     $metabox.="</p>";
     $metabox.=<<<EOD
<p>
<label for="cars">Choose student:</label>

<select id="cars" name="st_country[]" multiple>
EOD;
    $_st_country=is_array($_st_country)?$_st_country:array();
     foreach ($countries as $country){
         $selected=in_array($country,$_st_country)?'disabled selected':'';
         $metabox.=<<<EOD
    <option value="{$country}" {$selected}>{$country}</option>
EOD;

     }
     $metabox.="</select></p>";
     $metabox.=<<<EOD
</br>
</br>
<p>
<lebel for="year">Pubblish Year</lebel>
<input type="text" name="year" class="omb_datepikker" id="year" value="{$_date}">
</p>
EOD;

     echo $metabox;

}


}
new OurMetaBox();
