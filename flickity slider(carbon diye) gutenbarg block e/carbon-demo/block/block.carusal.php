<?php
use Carbon_Fields\Field;
use Carbon_Fields\Block;

add_action("enqueue_block_assets",function ($hook){
    wp_enqueue_style("flickity-css",plugins_url("/assets/css/flickity.css"));

});

function carbon_carusal_add_fields(){
Block::make( __( 'carusal',"carbon-demo") )
    ->add_fields( array(
        Field::make( 'media_gallery', 'crb_media_gallery', __( 'Media Gallery' ) )
    ) )
    ->set_keywords( array("carusal","carbon","description") )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
        ?>

        <?php
    } );
}
add_action("carbon_fields_register_fields","carbon_carusal_add_fields");