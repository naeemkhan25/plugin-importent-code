<?php
//arguments,$ccontent input holo,
[tSlider arguments]$content[/]
//r sudho arguments;
[tslider height width][/]
nasted judi use kora hoy tahole do_shortcode use korthe hobe.

function parent_tyniSLider($arguments,$content){
    $default=array(
        "height"=>800,
        "width"=>600,
        "id"=>''
    );
    $attributes=shortcode_atts($default,$arguments);
    $content=do_shortcode($content);
    $tSlider_output=<<<EOD
<div style="height:{$attributes['height']}; width:{$attributes['width']}" id="{$attributes['id']}">
<div class="slider">
{$content}
</div>
</div>
EOD;
return $tSlider_output;
}
add_shortcode("tSlider","parent_tyniSLider");
unction child_tyniSlider($arguments){
    $default=array(
      'caption'=>'',
        'id'=>'',
        'size'=>"tyniimage"


    );
    $attributes=shortcode_atts($default,$arguments);
    $image_src=wp_get_attachment_image_src($attributes['id'],$attributes['size']);

    $child_output=<<<EOD
<div class="slide">
<p>
<img src="{$image_src[0]}"  alt="{$attributes['caption']}">
</p>
<p>
{$attributes["caption"]}
</p>

</div>
EOD;
    return $child_output;
}

add_shortcode("tSlide","child_tyniSlider");