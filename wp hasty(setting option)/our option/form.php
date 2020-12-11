

<h4>our Option page</h4>
<form method="post" action="<?php echo admin_url('admin-post.php');?>" >
    <?php
    wp_nonce_field("OurOptionDrmo");
    $Data=get_option('OurOptionData');
    ?>
    <label for="ourExtraOption"><?php _e("ourExtraOption",'settings_option_demo')?></label>
    <input type="text" name="ourExtraOption" id="ourExtraOption" value="<?php echo $Data ?>">
    <input type="hidden" name="action" value="ourOption_demo_admin_page">
    <?php
    submit_button("save");
    ?>
</form>
