<?php
/*
Plugin Name: QR CODE GENARETOR
Plugin URI:
Description:Count word form any wordpress Post
Version: 1.0
Author: LWHH
Author URI:
License: GPLv2 or later
Text Domain:posts-to-qrCode
Domain Path:/languages/
*/




$pqrc_countries=array(
    'bangladesh',
    'india',
    'pakistan',
    'nepal',
    'africa',
    'japan',
    'iran'
);

function pqrc_init(){
    global $pqrc_countries;
    $pqrc_countries=apply_filters("pqrc_countries",$pqrc_countries);
}
add_action('init',"pqrc_init");

function plugin_load_textDomain_for_qrCOde(){
    load_plugin_textdomain("posts-to-qrCode",false,dirname(__FILE__)."/languages");
}
add_action("plugin_loaded","plugin_load_textDomain_for_qrCOde");


function sqrc_display($content){
    $current_ID=get_the_ID();
    $post_permalink=urlencode(get_the_permalink($current_ID));
    $post_title=get_the_title($current_ID);
    $post_type=get_post_type($current_ID);
    $height=get_option('sqrc_height');
    $width=get_option('sqrc_width');
    $height=$height?$height : 180;
    $width=$width?$width : 180;

    $excloud_post_type=apply_filters("excloud_post_type",array());
    $attribiut=apply_filters("image_attribuite",null);
    if(in_array($post_type,$excloud_post_type)){
        return $content;
    }
        $dimantion_size=apply_filters("size_height_width","{$width}x{$height}");
    $current_qr=sprintf('https://api.qrserver.com/v1/create-qr-code/?size=%s&ecc=L&qzone=1&data=%s',$dimantion_size,$post_permalink);
    $image=sprintf('<div><img src="%s" %s alt="%s"></div>',$current_qr,$attribiut,$post_title);
    $content.=$image;
    return $content;


}

add_filter("the_content","sqrc_display");
function sqrc_option_settings(){
    add_settings_section("sqrc_section",__("POSTS TO QR CODE","posts-to-qrCode"),"section_callback",'general');
    add_settings_field("sqrc_height",__("sqrc Height","posts-to-qrCode"),"sqrc_display_field","general",'sqrc_section',array('sqrc_height'));
    add_settings_field("sqrc_width",__("sqrc width","posts-to-qrCode"),"sqrc_display_field","general",'sqrc_section',array('sqrc_width'));
   add_settings_field("sqrc_countries",__("Select Countries","posts-to-qrCode"),"sqrc_display_countries","general",'sqrc_section');
   add_settings_field("sqrc_checkbox",__("Select multiple Countries","posts-to-qrCode"),"sqrc_display_checkbox_countries","general",'sqrc_section');
   add_settings_field("sqrc_minitoggle",__("Toogle Field","posts-to-qrCode"),"sqrc_display_toggle_field","general",'sqrc_section');

    register_setting('general',"sqrc_height",array("sanitize_callback"=>"esc_attr"));
    register_setting('general',"sqrc_width",array("sanitize_callback"=>"esc_attr"));
    register_setting("general",'sqrc_countries',array("sanitize_callback"=>"esc_attr"));
//    register_setting("general",'sqrc_checkbox',array("sanitize_callback"=>"esc_attr"));
    register_setting("general",'sqrc_checkbox');
    register_setting("general",'sqrc_minitoggle');
}
function sqrc_display_toggle_field(){
    echo '<div id="toggle1"></div>';
}

function section_callback(){

}

function sqrc_display_field($args){
        $data=get_option($args[0]);
    printf("<input type='text' name='%s' id='%s' value='%s'/>",$args[0],$args[0],$data);

}
function sqrc_display_countries(){
    global $pqrc_countries;
    $option=get_option('sqrc_countries');
        
    printf("<select id='%s' name='%s'>",'sqrc_countries','sqrc_countries');
    foreach ($pqrc_countries as $country){
        $selected=0;
        if($country==$option)$selected='selected';
        printf("<option value='%s' %s>%s</option>",$country,$selected,$country);

    }
    echo "</select>";

}
function sqrc_display_checkbox_countries(){
    global $pqrc_countries;
    $option=get_option('sqrc_checkbox');

    foreach ( $pqrc_countries as $country) {
        $checked='';
        if(is_array($option)&&in_array($country,$option)){
            $checked='checked';
        }

        printf('<input type="checkbox" name="sqrc_checkbox[]" id="sqrc_checkbox" value="%s" %s/>%s</br>',$country,$checked,$country);
    }

}
add_action("admin_init","sqrc_option_settings");
function sqrc_admin_assets($screen){
    if($screen=="options-general.php") {
        wp_enqueue_style("sqrc-minitoggile-css",plugin_dir_url(__FILE__) . "assets/css/minitoggle.css");
        wp_enqueue_script("sqrc-miniToggole-js",plugin_dir_url(__FILE__) . "assets/js/minitoggle.js",array("jquery"),time(),true);
        wp_enqueue_script("main-js", plugin_dir_url(__FILE__) . "/assets/js/sqrc_main.js",array("jquery"),time(),true);
    }
}
add_action("admin_enqueue_scripts","sqrc_admin_assets");
