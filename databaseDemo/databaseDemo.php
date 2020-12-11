<?php
/*
Plugin Name:Database Demo
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:databaseDemo
Domain Path:/languages/
*/
//dbDelta kaj kore plugin er database field e updata anle auto updata hoy.

define("DBDEMO_DB_VERSION","1.0");
function dbDemo_init(){
    global $wpdb;
    $table_name=$wpdb->prefix."persons";
    $sql="CREATE TABLE {$table_name} (
        id INT NOT NUll AUTO_INCREMENT,name VARCHAR(120),Email VARCHAR(120),
        PRIMARY KEY (id)
);";
    require_once (ABSPATH."wp-admin/includes/upgrade.php");
    dbDelta($sql);
    add_option("db_Demo_version_db",DBDEMO_DB_VERSION);
    if(get_option("db_Demo_version_db")!=DBDEMO_DB_VERSION){
        $sql="CREATE TABLE {$table_name} (
        id INT NOT NUll AUTO_INCREMENT,name VARCHAR(120),Email VARCHAR(120),
        age INT,
        PRIMARY KEY (id)
);";
        update_option("db_Demo_version_db",DBDEMO_DB_VERSION);
        dbDelta($sql);
    }
}
register_activation_hook(__FILE__,"dbDemo_init");

function dbDemo_updata_database_delete_column(){
        global $wpdb;
         $table_name=$wpdb->prefix."persons";
         if(get_option("db_Demo_version_db")!=DBDEMO_DB_VERSION){
             $query="ALTER TABLE {$table_name} DROP column age";
             $wpdb->query($query);
         }
    update_option("db_Demo_version_db",DBDEMO_DB_VERSION);

}
add_action("plugin_loaded","dbDemo_updata_database_delete_column");
function plugin_active_insert_data(){
    global $wpdb;
    $table_name=$wpdb->prefix."persons";
    $wpdb->insert($table_name,[
        'name'=>"Naeem khan",
        'Email'=>"Naeemkhan.cse@gmail.com"
    ]
    );
    $wpdb->insert($table_name,[
            'name'=>"mow khan",
            'Email'=>"mow.cse@gmail.com"
        ]
    );
}

register_activation_hook(__FILE__,"plugin_active_insert_data");
function plugin_deactive_delete_active_hok_insert_data(){
    global $wpdb;
    $table_name=$wpdb->prefix."persons";
    $query="TRUNCATE TABLE {$table_name}";
    $wpdb->query($query);

}

register_deactivation_hook(__FILE__,"plugin_deactive_delete_active_hok_insert_data");

function add_menu_in_admin_option(){
    add_menu_page(
        __("DB DEMO","databaseDemo"),
        __("DB DEMO","databaseDemo"),
        "manage_options",
        'dbDemo',
        'show_dbDemo_output'
    );

}
add_action("admin_menu","add_menu_in_admin_option");

function show_dbDemo_output(){
   global $wpdb;
    if(isset($_GET['id'])){
        if(!isset($_GET['db_edit_nonce'])|| !wp_verify_nonce($_GET['db_edit_nonce'],"db_edit")){
            wp_die("sorry you are not authorizid");
        }

    }
   $id=$_GET['id']??0;
   $id=sanitize_key($id);
   $did=$_GET['did']??0;
   if($did){

       $wpdb->get_row("DELETE FROM wp_persons WHERE id='{$did}'");
   }
   echo "<h1>DB DEMO</h1>";
   if($id){
       $result=$wpdb->get_row("SELECT * FROM wp_persons WHERE id='{$id}'");

   }
    //2oita vabe data submit kora jay database e ,
    //ekta php style r ekta admin_url er maddome.
    //jar jnno hiden value pass korthe hoibe

   ?>

<!--    <div class="notice notice-success is-dismissible">-->
<!--        <p>some success Information</p>-->
<!--    </div>-->

    <form action="<?php echo admin_url('admin-post.php');?>" method="POST">
        <?php
        wp_nonce_field("dbDemo",'dbNonce');
        ?>
<!--        admin_url diye data submit er jonno hidden field-->
        <input type="hidden" name="action" value="dbDemo_insert_data">

        <label for="Name">Name:</label>
        <input type="text" id="Name" name="name" placeholder="Name" value="<?php if($id){ echo $result->name;}?>">
    <br/>
        <label for="Email">E-mail</label>
        <input type="text" name="Email" id="Email" placeholder="Email" value="<?php if($id){ echo $result->Email;}?>">
        <?php
        if($id){
            ?>
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <?php
            submit_button("Update Record");
        }else {
            submit_button("add Record");
        }
        ?>
    </form>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <table class="table">
                    <?php
                    global $wpdb;
                    require_once "class.dbDemousers.php";
                    $data=$wpdb->get_results("SELECT* FROM {$wpdb->prefix}persons",ARRAY_A);
                    $dbDemo=new dbDemo($data);
                    $dbDemo->prepare_items();
                    $dbDemo->display();
                    ?>
                </table>
            </div>
        </div>
    </div>
<?php
    //2oita vabe data submit kora jay database e ,
    //ekta php style r ekta admin_url er maddome.
  /*  if(isset($_POST['submit'])){
        if(wp_verify_nonce($_POST["dbNonce"],'dbDemo'))
        $name=sanitize_text_field($_POST['name']);
        $Email=sanitize_text_field($_POST['Email']);
        $success='';
        if($name!=''&&$Email!=''&& is_email($Email)){
           $wpdb->insert("{$wpdb->prefix}persons",[
               "name"=>$name,
               'Email'=>$Email
           ]);
           $success="this value is successfully save";
           echo $success;

        }else{
            echo "plz enter valide email value your value";
        }


    }
  */

}
//admin post er por action er name ta hidden file value theke asbe admin_post er pore.
add_action("admin_post_dbDemo_insert_data",function (){
    global $wpdb;
    if(wp_verify_nonce($_POST["dbNonce"],'dbDemo'))
        $name=sanitize_text_field($_POST['name']);
    $Email=sanitize_text_field($_POST['Email']);
    $id=sanitize_text_field($_POST['id']);
    if($name!=''&&$Email!=''&& is_email($Email)) {
        if ($id) {

            $wpdb->update("{$wpdb->prefix}persons", ['name' => $name, 'Email' => $Email], ['id' => $id]);
            $nonce=wp_create_nonce("db_edit");
            wp_redirect(admin_url("admin.php?page=dbDemo&id=".$id."&db_edit_nonce=".$nonce));
        } else {
            $wpdb->insert("{$wpdb->prefix}persons", [
                "name" => $name,
                'Email' => $Email
            ]);
//            $new_id=$wpdb->insert_id;
//            wp_redirect(admin_url("admin.php?page=dbDemo&id=".$new_id));
            wp_redirect(admin_url("admin.php?page=dbDemo"));
        }

    }else{

        wp_redirect(admin_url("admin.php?page=dbDemo"));
    }


});
add_action("admin_enqueue_scripts",function ($hook){
    //toplevel_page aslo side bar theke r dbDemo slug.
   if("toplevel_page_dbDemo"==$hook){
       wp_enqueue_style("dbDemo-from-css",plugin_dir_url(__FILE__).'/assets/css/from.css');
       wp_enqueue_style("dbDemo-bootstrap","//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css");
   }
});
