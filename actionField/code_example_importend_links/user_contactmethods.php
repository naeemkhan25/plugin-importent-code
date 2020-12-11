<?php
//user form  meta info add er jonno use kora hoy
add_filter("user_contactmethods",array($this,"add_metabox_in_user_extra_info"));
function add_metabox_in_user_extra_info($methods){
     $methods["facebook"]=__("facebook","our_meatabox");
     return $methods;
}