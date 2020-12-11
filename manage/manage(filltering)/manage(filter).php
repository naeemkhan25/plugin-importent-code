<?php


function manage_posts_filter_columns(){

    if(isset($_GET['post_type'])&&$_GET['post_type']!='post'){
        return;
    }
    $_filter=isset($_GET['DREM11'])?$_GET['DREM11']:'';
    $filtering=array(

      1=>apply_filters("some_one",__("some One","manage-post-list")) ,
      2=>apply_filters("another_one",__("another One","manage-post-list"))
    );
    ?>
    <select name="DREM11">
        <?php
        foreach ($filtering as $key=>$value){
            printf("<option value='%s' %s>%s</option>",$key,$key==$_filter?'selected':'',$value);
        }
        ?>
    </select>
<?php
}
add_action("restrict_manage_posts","manage_posts_filter_columns");

function filter_post_DREM11($wpquery){
    if(!is_admin()){
        return;
    }
    $_filter=isset($_GET['DREM11'])?$_GET['DREM11']:'';
        if($_filter==1){
            $wpquery->set("post__in",array(1,540,12));
        } elseif($_filter==2){
        $wpquery->set("post__in",apply_filters("another_one_data",array(14,11)));
    }
}
add_action("pre_get_posts","filter_post_DREM11");