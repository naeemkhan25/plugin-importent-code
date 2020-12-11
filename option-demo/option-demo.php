
<?php
/*
Plugin Name:Option Demo
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:option-demo
*/

add_action("admin_enqueue_scripts",function ($hook){
    if("toplevel_page_option-demo"){
        wp_enqueue_style( 'pure-grid-css', '//unpkg.com/purecss@1.0.1/build/grids-min.css' );
        wp_enqueue_style( 'option-demo-css', plugin_dir_url( __FILE__ ) . "assets/css/style.css", null, time() );
        wp_enqueue_script( 'option-demo-js', plugin_dir_url( __FILE__ ) . "assets/js/main.js", array( 'jquery' ), time(), true );
        $nonce = wp_create_nonce( 'display_result' );
        wp_localize_script(
            "option-demo-js",
            "optionData",
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => $nonce )
        );

    }
});
add_action( 'wp_ajax_display_result', function () {
    if (wp_verify_nonce($_POST['nonce'], 'display_result')) {

        $task = $_POST['task'];
      if($task=="add-option"){
          $key="bd country";
          //option value ta key er upor nirbor kore key repert hole aita kaj insert nibe na.
          //value change hoile o.
          $value="bangladesh";
          $result=add_option($key,$value);
          if($result==1){
              echo "data successfully inserted";
          }else{
              echo "this data is already inserted";
          }
      }elseif($task=="add-array-option"){
          //jdui kono array k save korthe chai data value tile default vabe data serilize hisabe save hoy.
          //amra data jeson_encode kore o save korthe pari.
          $key='od-array';
          $value=json_encode(array("country"=>"bangladesh","capital"=>"dhaka"));
          $result=add_option($key,$value);
          echo "array insert successfully{$result}";
      }elseif ($task=="get-option"){
          $key="bd country";
          $result=get_option($key);
          echo $result;
      }elseif ($task=="get-array-option"){
          $key="od-array";
          //judi aita sirelize vabe save kori ta hole  aita auto unsirilize hoye array hisabe output dibe.
          //are judi jesone_encode hisabe save kroi ta hole jesone_docode korthe hoibe.
          $result=get_option($key);
            print_r($result);

      }
      elseif ($task=="option-filter-hook"){
          $key="od-array";
          $result=get_option($key);
          print_r($result);
      }elseif ($task=="update-option"){
          $key="bd-capital";
          $value="rajsahi";
          $result=update_option($key,$value);
          echo "data updata successfully.{$result}";
      }elseif ($task=="update-array-option"){
          $key='new-array';
          $value=array("country"=>"bangladesh","capital"=>"dhaka");
          $newValue=array("country"=>"peru","capital"=>"Lima");
          $result=update_option($key,$value);
          echo $result."<br/>";
          $result=update_option($key,$newValue);
          echo $result;
      }elseif ($task=="delete-option"){
          $key="bd-capital";
          $result=delete_option($key);
          echo "delete successfully.{$result}";
      }elseif($task=="export-option"){
          $key_noraml=array('bd country',"bd-capital");
          $key_array=array("new-array");
          $key_json=array('od-array');
          $export_data=[];
          foreach ($key_noraml as $key){
              $value=get_option($key);
              $export_data[$key]=$value;
          }
          foreach ($key_array as $key){
              $value=get_option($key);
              $export_data[$key]=$value;
          }
          foreach ($key_json as $key){
              $value=get_option($key);
              $export_data[$key]=$value;
          }
        echo json_encode($export_data);
      }elseif ($task=="import-option"){
          $data='{"bd country":"bangladesh","bd-capital":"rajsahi","new-array":{"country":"peru","capital":"Lima"},"od-array":{"COUNTRY":"BANGLADESH","CAPITAL":"DHAKA"}}';
          $new_array=json_decode($data,true);
          foreach ($new_array as $key=>$value){
              update_option($key,$value);
          }
      }
    }
    die(0);
});

add_filter("option_od-array",function($value){
     return json_decode(strtoupper($value),true);

});


add_action("admin_menu",function (){
    add_menu_page( 'Option Demo', 'Option Demo', 'manage_options', 'option-demo', 'option_admin_page' );
});
function option_admin_page(){
?>
    <div class="container" style="padding-top:20px;">
        <h1>Options Demo</h1>
        <div class="pure-g">
            <div class="pure-u-1-4" style='height:100vh;'>
                <div class="plugin-side-options">
                    <button class="action-button" data-task='add-option'>Add New Option</button>
                    <button class="action-button" data-task='add-array-option'>Add Array Option</button>
                    <button class="action-button" data-task='get-option'>Display Saved Option</button>
                    <button class="action-button" data-task='get-array-option'>Display Option Array</button>
                    <button class="action-button" data-task='option-filter-hook'>Option Filter Hook</button>
                    <button class="action-button" data-task='update-option'>Update Option</button>
                    <button class="action-button" data-task='update-array-option'>Update Array Option</button>
                    <button class="action-button" data-task='delete-option'>Delete Option</button>
                    <button class="action-button" data-task='export-option'>Export Options</button>
                    <button class="action-button" data-task='import-option'>Import Options</button>
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