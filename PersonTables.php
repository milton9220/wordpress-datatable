<?php

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once (ABSPATH."wp-admin/includes/class-wp-list-table.php");
}

class PersonTables extends WP_List_Table {
    function __construct( $args = array() ) {
        parent::__construct( $args );
    }

    function set_data( $data ) {
        $this->items = $data;
    }

    function get_columns() {
        return [
            'cb'    => '<input type="checkbox"/>',
            'name'  => 'Name',
            'city'  => 'City',
            'age'   => 'Age',
            'email' => 'Email',
        ];
    }
    function column_cb($item)
    {
        return "<input type='checkbox' value='{$item['id']}'/>";
    }
    function column_name($item)
    {
        return "<strong>{$item['name']}</strong>";
    }
    function column_email($item)
    {
        return "<strong>{$item['email']}</strong>";
    }
    function prepare_items()
    {
        $this->_column_headers=array($this->get_columns());
    }
    function column_default($item, $column_name)
    {
        return $item[$column_name];
    }
}
