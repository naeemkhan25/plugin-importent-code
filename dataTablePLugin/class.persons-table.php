<?php
if(!class_exists("WP_List_Table")){
    require_once ("ABSPATH"."wp-admin/includes/class-wp-list-table.php");
}
class personTable extends WP_List_Table {
    private $_items;
     function set_data($data){
        $this->_items=$data;

    }
    public function extra_tablenav($which)
    {
        if('top'==$which):
     ?>
        <div class="actions alignleft">
            <select name="felter_s" id="filter_s">
                <option value="all">All</option>
                <option value="F">Females</option>
                <option value="M">Male</option>
            </select>
            <?php
            submit_button(__("Filter","tableData"),"button","submit",false);
            ?>

        </div>
<?php
endif;

    }

    //colmun set er jonno
 function get_columns()
    {
     return [
         'cb'=>'<input type="checkbox">',
         'name'=>__("Name",'tableData'),
         'gender'=>__("Gender","tableData"),
         'email'=>__("E-mail",'tableData'),
         'age'=>__("Age",'tableData')
     ];
    }
    public function get_sortable_columns()
    {
        return [
            'age'=>[
                'age',true
            ]
        ];
    }
    //aita filter add er jonno

    function column_cb($item)
    {
       return "<input type='checkbox' value='{$item['id']}'>";
    }
    //colmun er sathe sudho key gulo diye kaj korbo.
    function column_email($item){
         return "<strong>{$item['email']}</strong>";
    }
    function  column_age($item){
         return "<em>{$item['age']}</em>";
    }
    //aita inital e run er jonno

    function prepare_items()
    {
        $paged=$_REQUEST["paged"]??1;
        $total_items=count($this->_items);
        $per_page=apply_filters("per_page",3);
        $data_chunk=array_chunk($this->_items,$per_page);
        //array key value onujaiya run hobe
        $this->items=$data_chunk[$paged-1];
       $this->_column_headers=array($this->get_columns(),array(),$this->get_sortable_columns());
     $this->set_pagination_args([
         'total_items'=>$total_items,
            'per_page'=>$per_page,
         'total_pages'=>ceil(count($this->_items)/$per_page)
     ]);

    }
    //colmun default data gulo $items er modde dukanor jonn
    //array er data gulo dekhanor jonno
     function column_default($item,$column_name)
    {
        return $item[$column_name];
    }


}

