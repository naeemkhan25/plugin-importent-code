<?php
//_thumbnail_id 
//_thumbnail_id meta the wordpress nije pass kore

function manage_posts_thumbanils_columns(){

    if(isset($_GET['post_type'])&&$_GET['post_type']!='post'){
        return;
    }
    $_filter=isset($_GET['thumbnails_filter'])?$_GET['thumbnails_filter']:'';
    $filtering=array(

        0=>apply_filters("all_thumbnails",__("all thumbnails","manage-post-list")) ,
        1=>apply_filters("has_thumbnails",__("Has thumbnails","manage-post-list")) ,
        2=>apply_filters("no_thumbnails",__("NO Thumbnails","manage-post-list"))
    );
    ?>
    <select name="thumbnails_filter">
        <?php
        foreach ($filtering as $key=>$value){
            printf("<option value='%s' %s>%s</option>",$key,$key==$_filter?'selected':'',$value);
        }
        ?>
    </select>
    <?php
}
add_action("restrict_manage_posts","manage_posts_thumbanils_columns");
function filter_post_thumbnails($wpquery){
    if(!is_admin()){
        return;
    }
    $_filter=isset($_GET['thumbnails_filter'])?$_GET['thumbnails_filter']:'';
    if($_filter==1){
        $wpquery->set('meta_query',array(
                array(
                    'key'=>'_thumbnail_id',
                    'compare'=>'EXISTS',
                )
        ));
    } elseif($_filter==2){
        $wpquery->set('meta_query',array(
            array(
                'key'=>'_thumbnail_id',
                'compare'=>'NOT EXISTS',
            )
        ));
    }
}
add_action("pre_get_posts","filter_post_thumbnails");
