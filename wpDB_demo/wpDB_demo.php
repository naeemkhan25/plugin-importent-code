<?php
/*
Plugin Name:WPDB DEMO
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:wpDB_demo
*/


function wbDB_init(){
    global $wpdb;
    $table_name=$wpdb->prefix. 'wpDemo';
    $sql="CREATE TABLE $table_name(
ID INT NOT NULL AUTO_INCREMENT,
name VARCHAR(120),
email VARCHAR(120),
age INT(11),
PRIMARY KEY(ID)
)";
    require_once ABSPATH."wp-admin/includes/upgrade.php";
    dbDelta($sql);

}

register_activation_hook(__FILE__,"wbDB_init");

add_action("admin_enqueue_scripts",function ($hook){
    if("toplevel_page_wpdb-demo"){
        wp_enqueue_style( 'pure-grid-css', '//unpkg.com/purecss@1.0.1/build/grids-min.css' );
        wp_enqueue_style( 'wpdb-demo-css', plugin_dir_url( __FILE__ ) . "assets/css/style.css", null, time() );
        wp_enqueue_script( 'wpdb-demo-js', plugin_dir_url( __FILE__ ) . "assets/js/main.js", array( 'jquery' ), time(), true );
        $nonce = wp_create_nonce( 'display_result' );
        wp_localize_script(
            "wpdb-demo-js",
            "plugindata",
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => $nonce )
        );

    }
});
add_action( 'wp_ajax_display_result', function () {
    if ( wp_verify_nonce( $_POST['nonce'], 'display_result' ) ) {
        global $wpdb;
        $table_name=$wpdb->prefix. 'wpDemo';
        $task = $_POST['task'];
       if($task=="add-new-record"){
         $persons=array(
                 "name"=>"naeem khan",
                "email"=>"naeemkhan.cse@gmail.com",
                "age"=>18
         );
         $wpdb->INSERT($table_name,$persons,array("%s","%s","%d"));
         echo "ADD a new record"."<br/>";
         echo "ID". " ". $wpdb->insert_id;
       }elseif ($task=="replace-or-insert"){
           //replace kaj kore judi sei id mele tile saita replace hoye jaibe ,are id  na mille new data insert korbe.
      $persons=array(
              "ID"=>3,
            "name"=>"mow",
          "email"=>"mowsumi.mukti@gmail.com",
          "age"=>22
      );
       $wpdb->replace($table_name,$persons);
       echo "replace successfully"."<br/>";
       if($wpdb->insert_id==3){
           echo "data  is updated";
       }else{
           echo "data is inserted";
       }

       }elseif ($task=="update-data"){
           $persons=array(
                   'age'=>'50'
           );
           $result=$wpdb->UPDATE($table_name,$persons,array("ID"=>1));
           echo "update successfully"."{$result}";

       }elseif ($task=="load-single-row"){
           $result=$wpdb->get_row("SELECT * FROM {$table_name} WHERE ID=3");//default object nibe
           print_r($result);
           $result=$wpdb->get_row("SELECT * FROM {$table_name} WHERE ID=3",ARRAY_A);//Array the rupantor
           print_r($result);
       }elseif ($task=="load-multiple-row"){
           $result=$wpdb->get_results("SELECT * FROM {$table_name}",ARRAY_A);//default object
           print_r($result);
           //arekta ache array key ta definde kora
           //protom email ta key hoye jabe array er.
           $result=$wpdb->get_results("SELECT email,ID,name,age FROM {$table_name}",OBJECT_K);
           print_r($result);

       }elseif ($task=="add-multiple"){
           $persons=array(
                   array(
                           "name"=>"mostak",
                       "email"=>"mostak@gmail.com",
                       "age"=>34
                   ),
               array(
                   "name"=>"masud",
                   "email"=>"masud@gmail.com",
                   "age"=>54
               )
           );
           foreach ( $persons as $person){
               $wpdb->insert($table_name,$person);

           }
           $result=$wpdb->get_results("SELECT * FROM {$table_name}",ARRAY_A);//default object
           print_r($result);
       }elseif ($task=="prepared-statement"){
           $id=2;
           $prepare_statement=$wpdb->prepare("SELECT * FROM {$table_name} WHERE ID>%d",$id);
           $result=$wpdb->get_results($prepare_statement,ARRAY_A);
           print_r($result);
       }elseif ($task=="single-column"){
           $result=$wpdb->get_col("SELECT name FROM {$table_name}");
           print_r($result);
       }elseif ($task=="single-var"){
           $result=$wpdb->get_var("SELECT COUNT(*) FROM {$table_name}");
          echo "count of all data{$result}<br/>";
          $result=$wpdb->get_var("SELECT name,email FROM {$table_name}",0,1);
          echo $result."name er 2oi number name";

       }elseif ($task=="delete-data"){
           $result=$wpdb->delete($table_name,array("ID"=>4));
           if($result==1){
               echo 'successfully';
           }
       }


    }
    die(0);
});

add_action("admin_menu",function (){
    add_menu_page( 'WPDB Demo', 'WPDB Demo', 'manage_options', 'wpdb-demo', 'wpdbdemo_admin_page' );
});
function wpdbdemo_admin_page(){
?>
<div class="container" style="padding-top:20px;">
    <h1>WPDB Demo</h1>
    <div class="pure-g">
        <div class="pure-u-1-4" style='height:100vh;'>
            <div class="plugin-side-options">
                <button class="action-button" data-task='add-new-record'>Add New Data</button>
                <button class="action-button" data-task='replace-or-insert'>Replace or Insert</button>
                <button class="action-button" data-task='update-data'>Update Data</button>
                <button class="action-button" data-task='load-single-row'>Load Single Row</button>
                <button class="action-button" data-task='load-multiple-row'>Load Multiple Row</button>
                <button class="action-button" data-task='add-multiple'>Add Multiple Row</button>
                <button class="action-button" data-task='prepared-statement'>Prepared Statement</button>
                <button class="action-button" data-task='single-column'>Display Single Column</button>
                <button class="action-button" data-task='single-var'>Display Variable</button>
                <button class="action-button" data-task='delete-data'>Delete Data</button>
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