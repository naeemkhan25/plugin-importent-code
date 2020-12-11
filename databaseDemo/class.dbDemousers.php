<?php
if(!class_exists("WP_List_Table")){
    require_once ("ABSPATH"."wp-admin/includes/class-wp-list-table.php");
}
class dbDemo extends WP_List_Table{
private $_items;
    public function __construct($data)
    {
        parent::__construct();
        $this->_items=$data;

    }

    public function get_columns()
    {
       return [
           'cb'=>'<input type="checkbox">',
           'name'=>__("Name","databaseDemo"),
           'Email'=>__("Email","databaseDemo"),
           'action'=>__("Action","databaseDemo"),
       ];
    }
    public function column_name($item){
        //nonce very importent
        $nonce=wp_create_nonce("db_edit");
        $actions=[

            'edit'=>sprintf('<a href="?page=dbDemo&id=%s&db_edit_nonce=%s">%s</a>',$item['id'],$nonce,"edit"),
            'delete'=>sprintf('<a href="?page=dbDemo&did=%s&db_edit_nonce=%s">%s</a>',$item['id'],$nonce,"Delete"),

        ];
      return sprintf("%s %s",$item['name'],$this->row_actions($actions));
    }

    function column_action($item){
        //er id and nonce name diye veryfi korthe  hoibe.
        //main page
        $link=wp_nonce_url(admin_url("admin.php?page=dbDemo&id=".$item['id']),"db_edit","db_edit_nonce");
        $deleteId=wp_nonce_url(admin_url("admin.php?page=dbDemo&did=".$item['id']),"db_delete","db_delete_nonce");
        return '<a href="'.esc_url($link).'"> Edit</a>'.'<a href="'.esc_url($deleteId).'"> delete</a>';
    }
    function column_cb($item)
    {
        return "<input type='checkbox' value='{$item['id']}'>";
    }

    public function column_default($item, $column_name)
    {
        return $item[$column_name];
    }
    public function prepare_items()
    {
        $per_page=2;
        $total_data=count($this->_items);
        $current_paged=$this->get_pagenum();

        $this->set_pagination_args([
            'total_items'=>$total_data,
                "per_page"=>$per_page,

            ]

        );
        $data=array_slice($this->_items,($current_paged-1)*$per_page,$per_page);
        $this->items=$data;

      $this->_column_headers=array($this->get_columns(),[],[]);
    }
}