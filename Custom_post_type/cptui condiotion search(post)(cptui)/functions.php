<?php
//header get_Search_form
function philosophy_search_form(){
    $action_url=home_url("/");
    $label_text=__("Search for:","philosophy");
    $button_label=__("Search","philosophy");
    $post_type=<<<PT
         <input type="hidden" name="post_type" value="post">
PT;
    if(is_post_type_archive('book')) {
        $post_type = <<<PT
        <input type="hidden" name="post_type" value=" ">
PT;
    }

    $newform=<<<FORM
 <form role="search" method="get" class="header__search-form" action="{$action_url}">
                        <label>
                            <span class="hide-content">{$label_text}</span>
                            <input type="search" class="search-field" placeholder="Type Keywords" value="" name="s" title="{$label_text}" autocomplete="off">
                        </label>
                     {$post_type}
                        <input type="submit" class="search-submit" value="{$button_label}">
             </form>
FORM;
return $newform;

}

add_filter("get_search_form","philosophy_search_form");