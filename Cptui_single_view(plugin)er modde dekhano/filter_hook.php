
<?php

function single_template_philosophy_cptui_plugin($file){
    global $post;
    if('book'==$post->post_type){
        $file_path=plugin_dir_path(__FILE__)."/Cptui_template/single-book.php";
        $file=$file_path;
    }
    return $file;
}
add_filter("single_template","single_template_philosophy_cptui_plugin");