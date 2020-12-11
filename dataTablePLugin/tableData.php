
<?php

/*
Plugin Name:Table Data
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:tableData
Domain Path:/languages/
*/

require_once "class.persons-table.php";
function tableData_load_plugin(){
    load_plugin_textdomain("tableData",false,dirname(__FILE__)."/languages");
}
add_action("plugins_loaded","tableData_load_plugin");
function tableData_add_option_menu(){
    add_menu_page(__("Data table","tableData"),
        __("Data table","tableData"),
    "manage_options",
        'dataTable',
        'datatable_display_table'
    );
}

function datatable_search_by_name($item){
    $name=$item['name'];
    $search_name=sanitize_text_field($_REQUEST['s']);
    if(stripos($name,$search_name)!==false){
        return true;
    }
        return false;

}
function datatable_filter_by_Gender($item){
    $gender=$item['gender'];
    $filter_gender=sanitize_text_field($_REQUEST["felter_s"]);
    if("all"==$filter_gender){
        return true;
    }else{
        if($gender==$filter_gender){
            return true;
        }
    }
    return false;
}

function datatable_display_table(){
    require_once "dataset.php";
    $table=new personTable();
    $ordery_by=$_REQUEST['orderby']??'';
    $ordery=$_REQUEST['order']??'';
    if('age'==$ordery_by){
        if('asc'==$ordery){
            usort($data,function ($item1,$item2){
                return $item1['age']<=>$item2['age'];
            });
        }else{
            usort($data,function ($item1,$item2){
                //<=>bor choto soman return kore
                return $item2['age']<=>$item1['age'];
            });
        }
    }
    if(isset($_REQUEST['s'])&&!empty($_REQUEST['s'])){
        $search_name=$_REQUEST['s'];

//        $data=array(
//            array(
//                'id'=>1,
//                'name'=>"naeem khan",
//                'email'=>'naeemkhan.cse@gmail.com',
//                'age'=>22
//            ),
//        );
        $data=array_filter($data,"datatable_search_by_name");
    }
    if(isset($_REQUEST['felter_s'])&&!empty($_REQUEST['felter_s'])){
        $filter_gender=$_REQUEST['felter_s'];
        $data=array_filter($data,"datatable_filter_by_Gender");
    }

    $table->set_data($data);
    $table->prepare_items();

    ?>
    <div class="wrap">
        <h2><?php _e("Persons","tableData") ?></h2>
        <form method="GET" action="">
            <?php
            $table->search_box("search","search_id");
            $table->display();
            ?>
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'];?>">

        </form>

    </div>
<?php

}
add_action("admin_menu","tableData_add_option_menu");

