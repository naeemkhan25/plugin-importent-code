<?php
/*
Plugin Name:Roles Demo
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:roles-demo
*/
add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( 'toplevel_page_roles-demo' == $hook ) {
        wp_enqueue_style( 'pure-grid-css', '//unpkg.com/purecss@1.0.1/build/grids-min.css' );
        wp_enqueue_style( 'roles-demo-css', plugin_dir_url( __FILE__ ) . "assets/css/style.css", null, time() );
        wp_enqueue_script( 'roles-demo-js', plugin_dir_url( __FILE__ ) . "assets/js/main.js", array( 'jquery' ), time(), true );
        $nonce = wp_create_nonce( 'roles_display_result' );
        wp_localize_script(
            'roles-demo-js',
            'plugindata',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => $nonce )
        );
    }
} );

add_action( 'wp_ajax_roles_display_result', function () {
//    global $roles;
//    $table_name = $roles->prefix . 'wpdemo';
    if ( wp_verify_nonce( $_POST['nonce'], 'roles_display_result' ) ) {
        $task = $_POST['task'];
        if($task=='current-user-details'){
            $current_user=wp_get_current_user();
            echo $current_user->user_email."<br/>";
            if(is_user_logged_in()){
                echo "some one is logdin";
            }
            print_r($current_user);
        }elseif ($task=='any-user-detail'){
            $any_user=new WP_User(2);

            print_r($any_user);
        }elseif ($task=="current-role"){
            $user_rol=wp_get_current_user();
            echo $user_rol->roles[0];
        }elseif($task=="all-roles"){
            global $wp_roles;
//            print_r($wp_roles);
            foreach ($wp_roles->roles as $role=>$roleData){
                echo $role."<br/>";
            }
            echo "<hr/>";
            $roles=get_editable_roles();
            foreach ($roles as $role=>$roledata){
                echo $role."<br/>";
            }
        }elseif ($task=="current-capabilities"){
            $current_user_info=wp_get_current_user();
            foreach ($current_user_info->allcaps as $capability=>$capabilityData){
                echo $capability."<br/>";

            }
        }elseif ($task=="create-user"){

            $new_user=wp_create_user("mow","abcd12","mow@gmail.com");
            echo $new_user;
            //aita the to amara role dey nai so ai default e subcriber role paibe
        }elseif ($task=="set-role"){
            $user=new WP_User(3);
            $user->remove_role("Subscriber");
            $user->set_role("author");
            print_r($user);
        }elseif($task=="login"){
//            $login=wp_authenticate("khan","khan");
//           if(is_wp_error($login)){
//               echo "failed";
//           }else{
//              wp_set_current_user($login->ID);
//              wp_set_auth_cookie($login->ID);
//           }
            //aita air er moddhomne
            $user=wp_signon([
                    "user_login"=>"khan",
                "user_password"=>"khan",
                "remember"=>true
            ]);
            if(is_wp_error($user)){
                echo "failed";
            }else{
                wp_set_current_user($user->ID);
                echo "success";
            }
        }elseif ($task=="users-by-role"){
            $user=get_users(array("role"=>"author","orderby"=>"user_email","order"=>"desc"));
            print_r($user);
        }elseif ($task=="create-role"){
//            $role=add_role("super_author","Super_author",array(
//                'edit_pages'=>true,
//                'edit_others_pages'=>true,
//                'edit_published_pages'=>true,
//                'publish_pages'=>true,
//                'delete_pages'=>true
//            ));
        $user=new WP_User(4);
        $user->add_role("super_author");
        print_r($user);

        }elseif ($task=="check-current-user_can"){
            $user_can=current_user_can("upload_files");
            if($user_can){
                echo "yes"."<br/>";
            }else{
                echo "no"."<br/>";
            }
            $user=new WP_User(3);
            $cap="delete_pages";
            if($user->has_cap($cap)){
                echo "yes"."<br/>";
            }else{
                echo "no";
            }
        }

    }
    die( 0 );
} );

add_action( 'admin_menu', function () {
    add_menu_page( 'roles Demo', 'Roles Demo', 'manage_options', 'roles-demo', 'rolesdemo_admin_page' );
} );

function rolesdemo_admin_page() {
    ?>
    <div class="container" style="padding-top:20px;">
        <h1>Roles Demo</h1>
        <div class="pure-g">
            <div class="pure-u-1-4" style='height:100vh;'>
                <div class="plugin-side-options">
                    <button class="action-button" data-task='current-user-details'>Get Current User Details</button>
                    <button class="action-button" data-task='any-user-detail'>Get Any User Details</button>
                    <button class="action-button" data-task='current-role'>Detect Any User Role</button>
                    <button class="action-button" data-task='all-roles'>Get All Roles List</button>
                    <button class="action-button" data-task='current-capabilities'>Current User Capability</button>
                    <button class="action-button" data-task='check-current-user_can'>check current User can</button>
                    <button class="action-button" data-task='create-user'>Create A New User</button>
                    <button class="action-button" data-task='set-role'>Assign Role To A New User</button>
                    <button class="action-button" data-task='login'>Login As A User</button>
                    <button class="action-button" data-task='users-by-role'>Find All Users From Role</button>
                    <button class="action-button" data-task='change-role'>Change User Role</button>
                    <button class="action-button" data-task='create-role'>Create New Role</button>
                </div>
            </div>
            <div class="pure-u-3-4">
                <div class="plugin-demo-content">
                    <h3 class="plugin-result-title">Result</h3>
                    <div id="plugin-demo-result" class="plugin-result"></div>
                </div>
            </div>
        </div>
    </div>
    <?php
}