<?php
/*
* Plugin Name: AWS Library
* Description: This plugin for AWS Library.
* Version: 1.0
* Author: PT. Moonlay Technologies
* Author URI: http://www.moonlay.com/
* License: GPL2
* Text Domain: aws_lib
* Domain Path: /languages
*/

function aws_install()
{
    include(dirname(__FILE__) . '/aws/aws-autoloader.php');
    include(dirname(__FILE__) . '/include/aws-function.php');
}

add_action('init','aws_install');

function add_jfw_script_lib(){
    //jQuery UI file
    wp_enqueue_script('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array('jquery'), '1.12.1');
    //jQuery UI theme css file
    wp_enqueue_style('jquery-ui-css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css', false, '1.12.1');

    //JS for multiple select dropdown
    wp_enqueue_script('multiple-select-ui', 'https://unpkg.com/multiple-select@1.3.1/dist/multiple-select.min.js', false, '1.3.1');
    //CSS for multiple select dropdown
    wp_enqueue_style('multiple-select-ui-css', 'https://unpkg.com/multiple-select@1.3.1/dist/multiple-select.min.css', false, '1.3.1');

    //JS for convert html to canvas
    wp_enqueue_script('html2canvas-js', 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js', false, '0.5.0');

    //JS for convert PDF
    wp_enqueue_script('jspdf-js', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js', false, '1.5.3');

    //JS SQL for convert to Excel
    wp_enqueue_script('alasql', 'https://cdn.jsdelivr.net/npm/alasql@0.4.11/dist/alasql.min.js', false, '0.4.11');

    //JS for convert data to xlsx
    wp_enqueue_script('xlsx', 'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.1/xlsx.core.min.js', false, '0.15.1');

    //JS for auto fit text to container
    wp_enqueue_script('textfill', 'https://cdn.jsdelivr.net/gh/jquery-textfill/jquery-textfill@0.6.0/source/jquery.textfill.min.js', false, '0.6.0');

    //css font file
    wp_enqueue_style('font-montserrat', 'https://fonts.googleapis.com/css?family=Montserrat', false, '1.0.0');}
add_action('admin_enqueue_scripts', 'add_jfw_script_lib');