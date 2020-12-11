<?php
/*
Plugin Name: Word Count
Plugin URI:
Description:Count word form any wordpress Post
Version: 1.0
Author: LWHH
Author URI:
License: GPLv2 or later
Text Domain: word-count
Domain Path:/languages/
 */
//function wordCunt_activation_hook(){
//
//}
//register_activation_hook(__FILE__,"wordCunt_activation_hook");
//
//function wordCount_Deactivation_hook(){
//
//}
//register_deactivation_hook(__FILE__,"wordCount_Deactivation_hook");

function plugin_load_textDomain(){
    load_plugin_textdomain("word-count",false,dirname(__FILE__)."/languages");
}
add_action("plugin_loaded","plugin_load_textDomain");
function wordCount_form_content($content){

    $trim=strip_tags($content);
    $coutn=str_word_count($trim);
    $lable=__("The Content word Count is","word-count");
    $lable=apply_filters("WORD_COUNT_Heading",$lable);
    $tag=apply_filters("WORD_COUNT_TAGS",'h2');
    $content.=sprintf("<%s>%s:%s</%s>",$tag,$lable,$coutn,$tag);
    return $content;

}
add_filter("the_content","wordCount_form_content");

function count_minut_for_word($content){
    $trim=strip_tags($content);
    //$coutn=str_word_count($trim);
    $coutn=900;
    $minuet=floor($coutn/200);
    $secend=floor($coutn%200/(200/60));
    $is_visiable=apply_filters("user_isset_value",1);
    if($is_visiable){
        $lable=__("TOTal Reading time ","word-count");
        $lable=apply_filters("WORD_Reading_Time",$lable);
        $tag=apply_filters("WORD_COUNT_TAGS_time",'h2');
        $content.=sprintf("<%s> %s : minuet  is %s seconds is %s</%s>",$tag,$lable,$minuet,$secend,$tag);
        return $content;
    }


}
add_filter("the_content","count_minut_for_word");



