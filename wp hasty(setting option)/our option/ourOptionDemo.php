<?php
class ourOptionDemo{
    public function __construct(){
        add_action("admin_menu",array($this,"our_option_Demo"));
        add_action("admin_post_ourOption_demo_admin_page",array($this,"ourOption_Demo_save_data"));
    }
    function our_option_Demo(){
        $page_title=__(" Our Option Demo","settings_option_demo");
        $menu_title=__(" Our Option Demo","settings_option_demo");
        $capability='manage_options';
        $slug='ourOptionDemo';
        $callback=array($this,"sod_our_settings_content");
        add_menu_page($page_title,$menu_title,$capability,$slug,$callback);
    }
    public function sod_our_settings_content(){
       require_once plugin_dir_path(__FILE__)."/form.php";
    }
    public function ourOption_Demo_save_data(){
        check_admin_referer('OurOptionDrmo');
       if(isset($_POST["ourExtraOption"])){
           update_option('OurOptionData',sanitize_text_field($_POST["ourExtraOption"]));
       }
       wp_redirect("admin.php?page=ourOptionDemo");

    }


}
new ourOptionDemo();