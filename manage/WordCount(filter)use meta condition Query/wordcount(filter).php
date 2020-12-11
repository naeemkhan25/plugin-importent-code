<?phpfunction manage_wordCount_filtaring(){

    if(isset($_GET['post_type'])&&$_GET['post_type']!='post'){
        return;
    }
    $_filter=isset($_GET['wordcount_filter'])?$_GET['wordcount_filter']:'';
    $filtering=array(

        0=>apply_filters("Word_count",__("word count","manage-post-list")) ,
        1=>apply_filters("400_UP",__("400 < up","manage-post-list")) ,
        2=>apply_filters("200_to_400",__("200 to 400","manage-post-list")),
        3=>apply_filters("200",__("200 >less","manage-post-list"))
    );
    ?>
    <select name="wordcount_filter">
        <?php
        foreach ($filtering as $key=>$value){
            printf("<option value='%s' %s>%s</option>",$key,$key==$_filter?'selected':'',$value);
        }
        ?>
    </select>
    <?php
}
add_action("restrict_manage_posts","manage_wordCount_filtaring");


function filter_wordCOunt($wpquery){
    if(!is_admin()){
        return;
    }
    $_filter=isset($_GET['wordcount_filter'])?$_GET['wordcount_filter']:'';
    if($_filter==1){
        $wpquery->set('meta_query',array(
            array(
                'key'=>'wordDataCount',
                'value'=>400,
                'compare'=>'>=',
                'type'=>'NUMERIC'
            )
        ));
    } elseif($_filter==2){
        $wpquery->set('meta_query',array(
            array(
                'key'=>'wordDataCount',
                'value'=>array(200,400),
                'compare'=>'BETWEEN',
                'type'=>'NUMERIC'
            )
        ));
    }elseif($_filter==3){
        $wpquery->set('meta_query',array(
            array(
                'key'=>'wordDataCount',
                'value'=>200,
                'compare'=>'<=',
                'type'=>'NUMERIC'
            )
        ));
    }
}
add_action("pre_get_posts","filter_wordCOunt");