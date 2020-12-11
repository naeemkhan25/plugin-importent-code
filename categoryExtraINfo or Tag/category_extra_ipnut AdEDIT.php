<?php
<?php
/*
Plugin Name:Tax Meta
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:Tax-Meta
*/
function tax_meta_plugin_load(){
    load_plugin_textdomain("tax-Meta",false,dirname(__FILE__)."/languages/");
}
add_action("plugin_loaded","tax_meta_plugin_load");

function taxm_bootstrap(){
    $args=array(
      'type'=>'string',
        'sanitize_callback'=>'sanitize_text_field',
        'description'=>'meta filed extra info fo taxonomy',
        'single'=>true,
        'show_in_rest'>true

    );
    register_meta('term',"taxonomy_extra_info",$args);
}
add_action("init","taxm_bootstrap");
function add_category_extra_meta(){
?>
<label for="extra_info"><?php _e("extra Info","tax-Meta");?></label>
	<input name="extra_info" id="extra_info" type="text" value="" size="40" aria-required="true">
	<p><?php _e("some extra info","tax_Meta"); ?></p>


<?php
}
add_action("category_add_form_fields","add_category_extra_meta");
//same field tag er jonno.
add_action("post_tag_add_form_fields","add_category_extra_meta");
//cptui coustom POst Type taxonomy er khetre./slug er name category ba post tag er bodel e .
add_action("genre_add_form_fields","add_category_extra_meta");


function edit_category_extra_meta($term){
    $extra_inf=get_term_meta($term->term_id,"taxonomy_extra_info",true);

?>
<tr class="form-field form-required term-name-wrap">
    <th scope="row">
        <label for="extra_info">extra info</label>

    </th>
    <td>
        <input name="extra_info" id="extra_info" type="text" value="<?php echo esc_attr($extra_inf); ?>" size="40" aria-required="true">
        <p class="description">The name is how it appears on your site.</p>
    </td>
</tr>
    <?php
}
add_action("category_edit_form_fields","edit_category_extra_meta");
add_action("post_tag_edit_form_fields","edit_category_extra_meta");
add_action("genre_edit_form_fields","edit_category_extra_meta");

function tax_meta_save_category($term_id){
            if(wp_verify_nonce($_POST['_wpnonce_add-tag'],'add-tag')){
               if(isset($_POST["extra_info"])&&!empty($_POST["extra_info"])){
                   $extra_info=sanitize_text_field($_POST["extra_info"]);
                   update_term_meta($term_id,"taxonomy_extra_info",$extra_info);
               }
            }

}
add_action("create_category","tax_meta_save_category");
add_action("create_post_tag","tax_meta_save_category");
//cptui taxonomy.
add_action("create_genre","tax_meta_save_category");
//ekhon amra edit option er value ka change korbo tar jonno amra abar noce field cheack korbo.
    //but ekhane jamela ache.inspectelement korle dekha editTag but kaj kore na .nonec.show inspectelement kora
//action er name dhore search dibo wordpress e . then instraction pobo.

function edit_category_extra_meta_info($term_id){
    if(wp_verify_nonce($_POST['_wpnonce'],"update-tag_{$term_id}")){
        if(isset($_POST["extra_info"])&&!empty($_POST["extra_info"])){
            $extra_info=sanitize_text_field($_POST["extra_info"]);
            update_term_meta($term_id,"taxonomy_extra_info",$extra_info);
        }
    }

}
    add_action("edit_category","edit_category_extra_meta_info");
    add_action("edit_post_tag","edit_category_extra_meta_info");
    //cptui er slug use kore .but same process.
    add_action("edit_genre","edit_category_extra_meta_info");