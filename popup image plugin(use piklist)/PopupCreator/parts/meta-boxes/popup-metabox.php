<?php
/*
Title: Popup settings
Post Type: popup_creator
*/
piklist('field', array(
    'type' => 'checkbox',
    'field' => 'popup_active',
    'label' => __("Active","popup_creator"),
    'value' => 1, // set default value
    'choices' => array(
        1=>__("Active","popup_creator")
    )
));
piklist('field', array(
    'type' => 'text',
    'field' => 'popup_Display_after',
    'label' => __("Display After exit","popup_creator"),
    'value' =>5,
    'help' => 'is Seconds',
));
piklist('field', array(
    'type' => 'url',
    'field' => 'popup_URL_field',
    'label' => __("URl","popup_creator"),


));
piklist('field', array(
    'type' => 'checkbox',
    'field' => 'popup_auto_hide',
    'label' => __("Auto Hide","popup_creator"),
    'value' => 1, // set default value
    'choices' => array(
       1=>__("don't Hide","popup_creator")
    )
));
piklist('field', array(
    'type' => 'radio',
    'field' => 'popup_On_exit',
    'label' => __("Display On exit","popup_creator"),
    'value' => 1, // set default value
    'choices' => array(
        0=>__("Display on exit","popup_creator"),
        1=>__("Display on page loaded","popup_creator"),

    )
));
piklist('field', array(
    'type' => 'select',
    'field' => 'popup_image_size',
    'label' => __("image_size","popup_creator"),
    'value' =>'popup_landscape', // set default value
    'choices' => array(
        'popup_landscape'=>__("landscape","popup_creator"),
        'popup_square'=>__("square","popup_creator"),
        'full'=>__("Full","popup_creator")
    )
));