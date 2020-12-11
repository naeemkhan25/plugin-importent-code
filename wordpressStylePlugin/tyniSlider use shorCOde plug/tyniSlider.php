<?php
/*
Plugin Name:TyniSlider
Plugin URI:
Description:Count word form any wordpress Post
Version: 1.0
Author: LWHH
Author URI:
License: GPLv2 or later
Text Domain:tyniSLider
Domain Path:/languages/
*/

function tyniSlider_load_textdomai(){
    load_plugin_textdomain("tyniSlider",false,dirname(__FILE__)."/languages");
}
add_action("plugin_loaded","tyniSlider_load_textdomai");

function tynislider_assets(){
    wp_enqueue_style("tynislider-css","//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css",null,"1.0");
    wp_enqueue_script("tynislider-js","//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js",null,"1.0",true);
    wp_enqueue_script("tynislider-main",plugin_dir_url(__FILE__)."assets/js/main.css",array("jquery"),time(),true);
}
add_action("wp_enqueue_scripts","tynislider_assets");
function tynislider_image_size(){
    add_image_size("tyniimage",400,400,true);
}

add_action("init","tynislider_image_size");
function parent_tyniSLider($arguments,$content){
    $default=array(
        "height"=>800,
        "width"=>600,
        "id"=>''
    );
    $attributes=shortcode_atts($default,$arguments);
    $content=do_shortcode($content);
    $tSlider_output=<<<EOD
<div style="height:{$attributes['height']}; width:{$attributes['width']}" id="{$attributes['id']}">
<div class="slider">
{$content}
</div>
</div>
EOD;
return $tSlider_output;
}
add_shortcode("tSlider","parent_tyniSLider");
function child_tyniSlider($arguments){
    $default=array(
      'caption'=>'',
        'id'=>'',
        'size'=>"tyniimage"


    );
    $attributes=shortcode_atts($default,$arguments);
    $image_src=wp_get_attachment_image_src($attributes['id'],$attributes['size']);

    $child_output=<<<EOD
<div class="slide">
<p>
<img src="{$image_src[0]}"  alt="{$attributes['caption']}">
</p>
<p>
{$attributes["caption"]}
</p>

</div>
EOD;
    return $child_output;
}

add_shortcode("tSlide","child_tyniSlider");