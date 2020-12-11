<?php

//admin panel er setting option er metafild add er jonno use hoy
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