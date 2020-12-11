<?php
/*
Plugin Name: Setting Option Demo
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:settings_option_demo
*/
require_once plugin_dir_path(__FILE__)."/ourOptionDemo.php";

class OptionDemo{
    public function __construct()
    {
        add_action("plugin_loaded",array($this,"sod_plugin_loaded"));
        add_action("admin_menu",array($this,"sod_optionDemo_menu"));
        add_action("admin_init",array($this,"sod_setup_section"));
        add_action("admin_init",array($this,"sod_setup_section_field"));
        add_filter("plugin_action_links_".plugin_basename(__FILE__),array($this,"sod_menu_settings_link"));
    }
    public function sod_plugin_loaded(){
        load_plugin_textdomain("settings_option_demo","false",plugin_dir_path(__FILE__).'/languages');
    }

    function  sod_menu_settings_link($links){
        $link=sprintf("<a href=%s>%s</a>",'options-general.php?page=optionDemo',__("Settings","settings_option_demo"));
        $links[]=$link;
        return $links;
    }
   public function sod_optionDemo_menu(){
       $page_title=__("Option Demo","settings_option_demo");
       $menu_title=__("Option Demo","settings_option_demo");
       $capability='manage_options';
       $slug='optionDemo';
       $callback=array($this,"sod_settings_content");
        add_options_page($page_title,$menu_title,$capability,$slug,$callback);
     //  add_menu_page($page_title,$menu_title,$capability,$slug,$callback);
//        add_media_page($page_title,$menu_title,$capability,$slug,$callback);
//        add_plugins_page($page_title,$menu_title,$capability,$slug,$callback);
//        add_comments_page($page_title,$menu_title,$capability,$slug,$callback);
    }
    function sod_settings_content(){
        ?>
        <div class="wrap">
            <h1><?php _e("Options Demo",("settings_option_demo")) ?></h1>
            <form method="POST" action="options.php">
                <?php
                //setting field gulo hidden field gulo dekhay.
                //do section e input field gulo dekhay.
                settings_fields('optionDemo');
                do_settings_sections("optionDemo");
                submit_button();
                ?>
            </form>
        </div>
<?php
    }
    function sod_setup_section(){
        add_settings_section("optionDemo_section",__("Option Demo Section","settings_option_demo"),array(),'optionDemo');
    }
    function sod_setup_section_field(){
       $fields=array(
           array(
               'label'=>__("latitude","settings_option_demo"),
               'id'=>'latitude_id',
               'type'=>'text',
               'placeholder'=>'Latitude',
               'section'=>'optionDemo_section',
           ),
           array(
               'label'=>__("longitude","settings_option_demo"),
               'id'=>'longitude_id',
               'type'=>'text',
               'placeholder'=>'longitude',
               'section'=>'optionDemo_section',
           ),
           array(
               'label'=>__("Zoom Label","settings_option_demo"),
               'id'=>'zoom_label_id',
               'type'=>'text',
               'section'=>'optionDemo_section',
           ),
           array(
               'label'=>__("API Key","settings_option_demo"),
               'id'=>'Api_Key_id',
               'type'=>'text',
               'section'=>'optionDemo_section',
           ),
           array(
               'label'=>__("External Css","settings_option_demo"),
               'id'=>'External_css_id',
               'type'=>'textarea',
               'section'=>'optionDemo_section',
           ),
           array(
               'label'=>__("Expiry Date","settings_option_demo"),
               'id'=>'expiry_date_id',
               'type'=>'date',
               'section'=>'optionDemo_section',
           )
       );

       foreach ($fields as $field){
           add_settings_field($field['id'],$field['label'],array(
               $this,"sod_option_field"
           ),
           'optionDemo',
           $field['section'],
           $field
           );
           //slug;
           register_setting('optionDemo',$field['id']);
       }
    }
    function sod_option_field($field){
        $option_value=get_option($field['id']);
        if($field['type']=='textarea'){
            printf("<textarea name='%s' id='%s' placeholder='%s' value='%s' row='5' cols='50'>%s</textarea>",$field['id'],$field['id'],isset($field['placeholder'])?$field['placeholder']:'',$option_value,$field['label'] );
        }else{
            printf("<input name='%s' id='%s' type='%s' placeholder='%s' value='%s'/>",$field['id'],$field['id'],$field['type'],isset($field['placeholder'])?$field['placeholder']:'',$option_value);
        }

    }
}
new OptionDemo();