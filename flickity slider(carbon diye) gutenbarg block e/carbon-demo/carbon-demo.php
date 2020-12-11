<?php
/*
Plugin Name:Carbon Demo
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:carbon-demo
*/
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Block;

function carbon_load(){
    require_once 'vendor/autoload.php';
    \Carbon_Fields\Carbon_Fields::boot();
}
add_action("plugin_loaded","carbon_load");
require_once "block.carusal.php";

function carbon_fields_add_fields(){
    wp_enqueue_style(
        'carb-css',
        plugins_url("/assets/tai.css",__FILE__),null,time()
    );
    wp_enqueue_script("carb-js",plugins_url("/assets/js/main.js",__FILE__),array("jquery"),time(),true);
    Block::make( __( 'Accordion' ,"carbon-demo") )
        ->add_fields( array(
            Field::make( 'complex', 'crb_accordion' )
                ->set_layout("tabbed-horizontal")
           ->add_fields( array(
                Field::make( 'text', 'crb_heading',__("heading","carbon-demo")),
                Field::make( 'textarea', 'crb_block',__("Block","carbon-demo")),
                ))
        ) )
      ->set_editor_style("carb-css")


        ->set_icon('format-chat')
        ->set_keywords( array("accordion","text","description") )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
?>
            <div class="block accordion-container">
                <?php
                foreach ($fields["crb_accordion"] as $accordion){
                    ?>
                    <div class="accrodion">
                        <h3 class="title"><?php echo esc_html($accordion["crb_heading"]); ?></h3>
                    <div class="body">
                            <?php echo apply_filters("the_content",$accordion['crb_block']); ?>
                    </div>
                    </div>
                        <?php
                }
                ?>
            </div>
<?php
        });

}
add_action("carbon_fields_register_fields","carbon_fields_add_fields");