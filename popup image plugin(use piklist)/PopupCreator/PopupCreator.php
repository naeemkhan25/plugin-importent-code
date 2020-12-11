<?php
/*
Plugin Name:Popup Creator
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:PopupCreator
Plugin Type: Piklist
*/
class PopupCreator{
    public function __construct()
    {
        add_action("plugin_loaded",array($this,"PopupCreator_plugin_setup"));
        add_action("init",array($this,"register_cpt_ui"));
        add_action("init",array($this,"add_image_size"));
        add_action("wp_enqueue_scripts",array($this,"enqueue_popup_assets"));
        add_action("wp_footer",array($this,"popupcreator_add_footer"));


    }
    function PopupCreator_plugin_setup(){
        load_plugin_textdomain("PopupCreator",false,plugin_dir_path(__FILE__)."/languages");

    }
    function popupcreator_add_footer(){
                $arrg=array(
                        "post_type"=>'popup_creator',
                        'meta_key'=>'popup_active',
                    'meta_value'=>1
                );
        $_sp=new WP_Query(
            $arrg
        );
        while ($_sp->have_posts()){
            $_sp->the_post();
            $image_size=get_post_meta(get_the_ID(),"popup_image_size",true);
            $on_exits=get_post_meta(get_the_ID(),"popup_On_exit",true);
            $delay=get_post_meta(get_the_ID(),"popup_Display_after",true);
            if($delay>0){
                $delay*=1000;
            }else{
                $delay=0;
            }
            $image=get_the_post_thumbnail_url(get_the_ID(),$image_size);

            ?>

        <div class="modal-content" data-modal-id="<?php the_ID();?>" data-exit="<?php echo esc_attr($on_exits)?>" data-delay="<?php echo esc_attr($delay); ?>">

            <div><img class="close-button" width="30"
                      src="<?php echo  plugin_dir_url(__FILE__)."/assets/img/x.jpg"; ?>" alt="<?php _e("Close","PopupCreator")?>"></div>
                <img  src="<?php echo esc_url($image); ?>" alt="">



        </div>

        <?php
            wp_reset_query();
        }
    }
    function add_image_size(){
        add_image_size("popup_landscape",600,400,true);
        add_image_size("popup_square",400,400,true);
    }
    function enqueue_popup_assets(){
        wp_enqueue_script("popupcreator-css",plugin_dir_url(__FILE__)."/assets/css/plain-modal.css",null,time());
        wp_enqueue_script("plain-modal",plugin_dir_url(__FILE__)."assets/js/plain-modal.js",array("jquery"),time(),true);
        wp_enqueue_script("popupcreator-main-js",plugin_dir_url(__FILE__)."assets/js/popupcreator-main.js",array(
            "jquery",
            "plain-modal"
            ),
            time(),true);
    }


    function register_cpt_ui() {

        /**
         * Post Type: Popup Creator.
         */

        $labels = [
            "name" => __( "Popup Creator", "PopupCreator" ),
            "singular_name" => __( "popup creator", "PopupCreator" ),
            "featured_image" => __( "popup creator imgage", "PopupCreator" ),
            "set_featured_image" => __( "Set popup creator image", "PopupCreator" ),
        ];

        $args = [
            "label" => __( "Popup Creator", "PopupCreator" ),
            "labels" => $labels,
            "description" => "",
            "public" => false,
            "publicly_queryable" => true,
            "show_ui" => true,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "has_archive" => false,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "delete_with_user" => false,
            "exclude_from_search" => true,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "rewrite" => [ "slug" => "popup_creator", "with_front" => true ],
            "query_var" => true,
            "supports" => [ "title", "thumbnail" ],
        ];

        register_post_type( "popup_creator", $args );
    }


}
new PopupCreator();