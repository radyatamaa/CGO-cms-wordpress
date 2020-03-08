<?php
/*
* Plugin Name: Category Travel
* Description: This plugin for Category Travel Management.
* Version: 1.0
* Author: PT. Moonlay Technologies
* Author URI: http://www.moonlay.com/
* License: GPL2
* Text Domain: Category Travel
* Domain Path: /languages
*/

defined('ABSPATH') or die();

require(ABSPATH . '/wp-load.php');


function category_travel_install(){
    global $wpdb;
    global $category_travel_db_version;

    $table_name = $wpdb->prefix .'category_travel';

$sql ="CREATE TABLE  {$table_name} (
    id int(11) NOT NULL AUTO_INCREMENT,
    category_name varchar(255) NOT NULL,
    created_by varchar(50) NOT NULL,
    modified_by varchar(50),
    created_date TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
    modified_date TIMESTAMP NULL,
    is_deleted TINYINT(1) NOT NULL,
    is_active TINYINT(1) NOT NULL,
    PRIMARY KEY(id)
    ) ENGINE=INNODB;";


    require_once(ABSPATH. 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    add_option('category_travel_db_version', $category_travel_db_version);

    $installed_ver = get_option('category_travel_db_version');
    
    if($installed_ver != $category_travel_db_version){
        require_once(ABSPATH. 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        update_option('category_travel_db_version', $category_travel_db_version);


    }


}


register_activation_hook(__FILE__, 'category_travel_install');