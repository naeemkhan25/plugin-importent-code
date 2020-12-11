<?php
use Carbon_Fields\Field;
use Carbon_Fields\Block;

add_action("enqueue_block_assets",function ($hook){
    wp_enqueue_style("flickity-css",plugin_dir_url(__FILE__)."assets/css/flickity.css",[],time());
    wp_enqueue_style("flickity-main",plugin_dir_url(__FILE__)."assets/css/main.css",null,time());
    wp_enqueue_script("flickity-main-js",plugin_dir_url(__FILE__)."assets/js/flickity.pkgd.min.js",array("jquery"),time(),true);
});

function carbon_carusal_add_fields(){
Block::make( __( 'carusal',"carbon-demo") )
    ->add_fields( array(
        Field::make( 'media_gallery', 'crb_media_gallery', __( 'Media Gallery' ) )
    ) )
    ->set_keywords( array("carusal","carbon","description") )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
        ?>

        <div class="main-carousel">
            <?php
           foreach ( $fields['crb_media_gallery'] as $mediaData){
               ?>
            <div class="carousel-cell">
                <?php
                echo wp_get_attachment_image($mediaData,"large");
                ?>
            </div>
               <?php
           }
            ?>

        </div>

        <?php
    } );
}
add_action("carbon_fields_register_fields","carbon_carusal_add_fields");