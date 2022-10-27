<?php  
/****
Plugin Name:Data Table
Plugin URI:
Author: Milton
Author URI:
Description: Our 2019 default theme is designed to show off the power of the block editor. It features custom styles for all the default blocks, and is built so that what you see in the editor looks like what you'll see on your website. Twenty Nineteen is designed to be adaptable to a wide range of websites, whether you’re running a photo blog, launching a new business, or supporting a non-profit. Featuring ample whitespace and modern sans-serif headlines paired with classic serif body text, it's built to be beautiful on all screen sizes.
Version: 1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: 
******/

require_once("PersonTables.php");

function dataset_admin_page(){
    add_menu_page('Dataset','Dataset','manage_options','dataset','render_dataset_table');
}

/**Data search array filter callback function */

function datatable_search_by_name($data){
    $name=strtolower($data['name']);
    $search_name=sanitize_text_field($_REQUEST['s']);
    if(strpos($name,$search_name) !==false){
        return true;
    }
    return false;
}

/**Data search array filter callback function end */

function datatable_filter_by_sex($data){
    $sex=$_REQUEST['filter_sex'];
    $sex=$sex ?? 'all';
    if('all'==$sex){
        return true;
    }else{
        if($sex==$data['sex']){
            return true;
        }
    }
    return false;
}

function render_dataset_table(){
    include_once "dataset.php";

    $order_by=$_REQUEST['orderby'] ?? '';
    $order=$_REQUEST['order'] ?? '';

    /**Before set table data if has search request */

    if(isset($_REQUEST['s']) && !empty($_REQUEST['s'])){
        $data=array_filter($data,'datatable_search_by_name');
    }

    /**Before set table data if has search request code end */

    /**Before set table data if has data filter  request */

    if(isset($_REQUEST['filter_sex']) && !empty($_REQUEST['filter_sex'])){
        $data=array_filter($data,'datatable_filter_by_sex');
    }

    /**Before set table data if has data filter  request code end */

    $table= new PersonTables();

    /**Before set table data it sortable if has any request data */
    if($order_by=='age'){
        if($order=='asc'){
            usort($data,function($item1,$item2){
                return $item1['age']<=>$item2['age'];
            });
        }else{
            usort($data,function($item1,$item2){
                return $item2['age']<=>$item1['age'];
            });
        }
    }
    else if($order_by=='name'){
        if($order=='asc'){
            usort($data,function($item1,$item2){
                return $item1['name']<=>$item2['name'];
            });
        }else{
            usort($data,function($item1,$item2){
                return $item2['name']<=>$item1['name'];
            });
        }
    }
    /**Before set table data it sortable if has any request data code end*/

    $table->set_data($data);

    $table->prepare_items();
    ?>
    <div class="wrap">
        <h2>Person's</h2>
        <form method="GET">  
            <?php 
                $table->search_box('search','search_box');
                $table->display();
            ?>
            <input type="hidden" name="page" value="dataset">
        </form>
    </div>
    <?php 
}
add_action('admin_menu','dataset_admin_page');
