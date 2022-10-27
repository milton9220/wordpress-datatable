<?php

if ( !class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . "wp-admin/includes/class-wp-list-table.php";
}

class PersonTables extends WP_List_Table {
    private $_items;
    function __construct( $args = array() ) {
        parent::__construct( $args );
    }

    function set_data( $data ) {
        $this->_items = $data;
    }

    function get_columns() {
        return [
            'cb'    => '<input type="checkbox"/>',
            'name'  => 'Name',
            'sex'   =>'Sex',
            'city'  => 'City',
            'age'   => 'Age',
            'email' => 'Email',
        ];
    }

    function column_cb( $item ) {
        return "<input type='checkbox' value='{$item['id']}'/>";
    }
    function extra_tablenav($which)
    {
        if ('top'==$which) { ?>
            <div class="actions alignLeft">
                <select name="filter_sex" id="filter_sex">
                    <option value="all">All</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <?php submit_button('Filter','button','submit',false); ?>
        <?php }
    }
    function column_name( $item ) {
        return "<strong>{$item['name']}</strong>";
    }

    function column_email( $item ) {
        return "<strong>{$item['email']}</strong>";
    }

    function get_sortable_columns() {
        return [
            'age'  => ['age', true],
            'name' => ['name', true],
        ];
    }

    function prepare_items() {
        $this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );

        $this->tableDataPagination();
    }

    public function tableDataPagination() {

        $paged=isset($_REQUEST['paged']) ? sanitize_text_field($_REQUEST['paged']):1;
        $data_per_page=2;
        $data_chunk=array_chunk($this->_items,$data_per_page);
        $this->items=$data_chunk[$paged-1];
        $this->set_pagination_args(
            [
                'total_items' => count( $this->_items ),
                'per_page'    => $data_per_page,
                'total_pages' => ceil( count( $this->_items ) / $data_per_page ),
            ]
        );
    }

    function column_default( $item, $column_name ) {
        return $item[$column_name];
    }

}
