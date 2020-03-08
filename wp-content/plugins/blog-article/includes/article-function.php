<?php 
//Audition Event function
/**
 * Get all audition event
 * 
 * @param $args array
 * 
 * @return array
 */
// spl_autoload_register(function ($class) {
//     require_once str_replace("\\", "/", $class) . ".php";
// });

function get_all_article($args = array()){
    global $wpdb;
    $table_name = $wpdb->prefix.'article';

    $defaults = array(
        'number'=>20,
        'offset' => 0,
        'orderby' => 'created_date',
        'order' => 'DESC',
    );

    $args = wp_parse_args($args , $defaults);
    $cache_key = 'article-all';
    $items = wp_cache_get($cache_key, 'art');

    if(false === $items){


        $query = 'SELECT * FROM '.$table_name.' WHERE is_deleted = 0';

        if(isset($_REQUEST['s']) && $_REQUEST['s'] != ''){
            $query = $query .' AND '.$table_name.'.name LIKE "%' .$_REQUEST['s']. '%"';
        }

        $query = $query. ' ORDER BY '.$table_name.'.'  .$args['orderby']. ' '. $args['order'] . ' LIMIT '. $args['offset'] . ', ' .$args['number'];
        $items = $wpdb->get_results($query);

        wp_cache_set($cache_key, $items,'art');
    }

    return $items;

 }

 function get_article_by_id($id){
    global $wpdb;
    $table_name = $wpdb->prefix.'article';

    $query = "SELECT * FROM $table_name WHERE id = $id";

    $item = $wpdb->get_row($query);

    return $item;
 }
 
function get_all_article_api($request = array()){
    global $wpdb;
    $table_name = $wpdb->prefix.'article';

    $args = array(
        'offset' => isset($request['page']) ? intval($request->get_param('page')) : '',
        'number' => isset($request['size']) ? intval($request->get_param('size')) : '',
        'search' => isset($request['search']) ? stripslashes(sanitize_text_field($request->get_param('search'))) : '',
    );

    $defaults = array(
        'number'=>20,
        'offset' => 0,
        'orderby' => 'created_date',
        'order' => 'DESC',
    );

    $args = wp_parse_args($args , $defaults);
    if($args['number'] == '' && $args['offset'] == ''){
        $args['offset'] = 0;
        $args['number'] = 20;
    }
    $cache_key = 'article-all';
    $items = wp_cache_get($cache_key, 'art');

    if(false === $items){


        $query = 'SELECT * FROM '.$table_name.' WHERE is_deleted = 0';

        if(isset($args['search']) && $args['search'] != ''){
            $query = $query .' AND '.$table_name.'.title LIKE "%' .$args['search']. '%"';
        }

        $query = $query. ' ORDER BY '.$table_name.'.'  .$args['orderby']. ' '. $args['order'] . ' LIMIT '. $args['offset'] . ', ' .$args['number'];
        $items = $wpdb->get_results($query);

        wp_cache_set($cache_key, $items,'art');
    }

    return $items;

 }

 function get_article_by_id_api($request = array()){
    global $wpdb;

    $id = isset($request['id']) ? intval($request->get_param('id')) : '';

    $table_name = $wpdb->prefix.'article';

    $query = "SELECT * FROM $table_name WHERE id = $id";

    $item = $wpdb->get_row($query);

    $item->category_travel = json_decode($item->category_travel);

    return $item;
 }

function get_category_by_id($id){
    global $wpdb;
    $table_name = $wpdb->prefix.'category_travel';

    $query = "SELECT * FROM $table_name WHERE id = $id";

    $item = $wpdb->get_row($query);

    return $item;
}
function get_all_categorys(){
    global $wpdb;
    $table_name = $wpdb->prefix.'category_travel';

    $query = "SELECT * FROM $table_name WHERE is_deleted = 0";

    $items = $wpdb->get_results($query);

    return $items;
}

 /**
  * Fetch all audition event from database
  *
  * @return array
  */
  function get_count_article(){
      global $wpdb;
      $table_name = $wpdb->prefix.'article';

      $query = 'SELECT COUNT(*) FROM ' .$table_name .' WHERE is_deleted = 0';

      if ( isset( $_REQUEST['s'] ) && $_REQUEST['s'] != '' ) {
        $query = $query . ' AND name LIKE "%' . $_REQUEST['s'] . '%"';
    }

    return (int)$wpdb->get_var($query);

}

function upload_image_s3($directory)
{
    $ObjectUrl = '#';
    if ($_FILES['url_file']['size'] > 0) {
        $bucket = 'cgo-indonesia-dev';
        $temp_file_location = $_FILES['url_file']['tmp_name'];

        $s3 = new Aws\S3\S3Client([
            'region'  => 'ap-southeast-1',
            'version' => 'latest'
        ]);

        // check redundancy filename
        $filename = aws_s3_check_image_exists($bucket, $_FILES['url_file'], $s3,$directory);

        try {
            // Upload data.
            $result = $s3->putObject([
                'Bucket' => $bucket,
                'Key'    => $filename,
                'SourceFile' => $temp_file_location,
                'ContentType' => mime_content_type($temp_file_location),
                'ACL'    => 'public-read',
                'connection_timeout' => 0
            ]);

            // Print the URL to the object.
            $ObjectUrl = $result['ObjectURL'];
        } catch (Aws\S3\Exception\S3Exception $e) {
            return new WP_Error('error-image-upload', __('Error : ' . $e->getMessage() . PHP_EOL, 'scdl'));
        }
    }
    return $ObjectUrl;
}

function create_article($args = array())
    {
        global $wpdb;
        $table_name= $wpdb->prefix.'article';
        $current_user = wp_get_current_user();
        $defaults = array(
            'id' => null,
            'created_by' => $current_user->user_login,
            'is_deleted' => 0,
            'is_active' => 1
        );
        $args = wp_parse_args($args, $defaults);
        $wpdb->insert($table_name , $args);
        if($wpdb->result){
            return $wpdb->insert_id;
        } else {
            return new WP_Error('sql-failed', __('Error : ' . $wpdb->last_error, 'art'));
        }        
        return false;
    }
function update_article($args = array()){
        global $wpdb;
        $table_name= $wpdb->prefix.'article';
        $current_user = wp_get_current_user();
        $current_date = date_create();
        $defaults = array(
            'id' => null,
            'modified_by' => $current_user->user_login,
            'modified_date' => date_format($current_date, 'Y-m-d H:i:sP'),
            'is_deleted' => 0,
            'is_active' => 1
        );
        $args = wp_parse_args($args, $defaults);
        $id = $args['id'];
        if (isset($args['url_file']) && $args['url_file'] === '#') unset($args['url_file']);
        $wpdb->update($table_name, $args, array('id' => $id));
        if (!$wpdb->result) {
            return new WP_Error('sql-failed', __('Warning : ' . $wpdb->last_error, 'bnr'));
        }  
    }

function delete_article($id){
        global $wpdb;
        $table_name= $wpdb->prefix.'article';
        $current_user = wp_get_current_user();
        $current_date = date_create();
        $args = array(
            'id' => $id,
            'modified_by' => $current_user->user_login,
            'modified_date' => date_format($current_date, 'Y-m-d H:i:sP'),
            'is_deleted' => 1,
            'is_active' => 0
        );
        $wpdb->update($table_name, $args, array('id' => $id));
        if (!$wpdb->result) {
            return new WP_Error('sql-failed', __('Warning : ' . $wpdb->last_error, 'bnr'));
        }
}
    

?>