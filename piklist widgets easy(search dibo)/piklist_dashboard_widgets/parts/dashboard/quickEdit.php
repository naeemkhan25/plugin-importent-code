<?php
/*
Title: Quick edit post
Capability: manage_options
*/
?>
<?php
$_p=new WP_Query(
        array(
            'post_type'=>'post',
            'meta_key'=>'featured',
            'meta_value'=>1
        )
);


while($_p->have_posts()){

    $_p->the_post();

echo get_the_ID()."<br/>";
}


?>
<ul>
    <?php
//foreach ($pdl_post_list as $postList){
//        printf("<li><a href='%s'>%s</a></li>",$postList['link'],$postList['title']);
//}
?>
</ul>


