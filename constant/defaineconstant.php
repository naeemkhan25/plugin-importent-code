<?php

define("ASN_ASSETS_DIR",plugin_dir_url(__FILE__)."assets/");
define("ASN_ASSETS_PUBLIC_DIR",plugin_dir_url(__FILE__)."assets/public/");
define("ASN_ASSETS_ADMIN_DIR",plugin_dir_url(__FILE__)."assets/admin/");
define("ASN_VERSION",time());
example:
   wp_enqueue_style("oopNinja-main-css",ASN_ASSETS_PUBLIC_DIR."/css/main.css",null,time());