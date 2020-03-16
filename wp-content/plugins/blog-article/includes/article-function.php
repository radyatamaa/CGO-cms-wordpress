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
            $query = $query .' AND '.$table_name.'.title LIKE "%' .$_REQUEST['s']. '%"';
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

    // $item->category_travel = json_decode($item->category_travel);

    return $item;
 }

 function get_user_by_username_api($request = array()){
    global $wpdb;

    $username = isset($request['username']) ? stripslashes(sanitize_text_field($request->get_param('username'))) : '';

    $table_name = $wpdb->prefix.'users';

    $query = "SELECT * FROM $table_name WHERE user_login = '$username'";

    $item = $wpdb->get_row($query);

    unset($item->user_pass,$item->user_registered,$item->user_activation_key);
    
    if($item == null){
        $item = new stdClass;
    }

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

function get_article_by_category_id_api($request = array()){
    global $wpdb;

    $category_ids = isset($request['category_ids']) ? stripslashes(sanitize_text_field($request->get_param('category_ids'))) : '';

    $table_name = $wpdb->prefix.'article';

    $query = "SELECT * FROM $table_name WHERE ";

    $category_array = json_decode($category_ids);

    foreach($category_array as $index => $val){

        if($index == 0){
            $query .= 'category_travel LIKE ' . '"%' . $val . '%"';
        }else{
            $query .= ' OR category_travel LIKE ' . '"%' . $val . '%"';
        }
    }

    $item = $wpdb->get_results($query);

    return $item;
 }

function get_by_id_category($request = array()){
    global $wpdb;

    $category_ids = isset($request['id']) ? stripslashes(sanitize_text_field($request->get_param('id'))) : '';

    $table_name = $wpdb->prefix.'category_travel';
    
    $query = "SELECT * FROM $table_name WHERE ";

    $category_ids_array = json_decode($category_ids);

    foreach($category_ids_array as $index => $val){
        if($index == 0){
            $query .= 'id=' . $val;
        }else{
            $query .= ' OR id=' . $val;
        }
    }

    $item = $wpdb->get_results($query);

    return $item;

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

function upload_image($directory,$column_name){
    
// VARIABLES
// These are used in multiple places in the request. Replace the
// values with ones appropriate to you.
$accessKeyId = 'AKIAJERZME7OXRG2EGVQ';
$secretKey = 'zxHgl8hCa+VimNMNp9HOiX3Fjq8wA3kgnlqIF8ri';
$bucket = 'cgo-indonesia-dev';
$region = 'ap-southeast-1'; // us-west-2, us-east-1, etc
$acl = 'public-read'; // private, public-read, etc
$filePath = $_FILES[$column_name]['tmp_name'];
$fileName = $directory . '/' . uniqid() . '.jpeg';
$fileType = 'image/jpeg';

// POST POLICY
// Amazon requires a base64-encoded POST policy written in JSON.
// This tells Amazon what is acceptable for this request. For
// simplicity, we set the expiration date to always be a day in 
// the future. The two "starts-with" fields are used to restrict
// the content of "key" and "Content-Type", which are specified
// later in the POST fields. Again for simplicity, we use blank
// values ('') to not put any restrictions on those two fields.
$policy = base64_encode(json_encode(array(
    'expiration' => gmdate('Y-m-d\TH:i:s\Z', time() + 86400),
    'conditions' => array(
        array('acl' => $acl),
        array('bucket' => $bucket),
        array('starts-with', '$key', ''),
        array('starts-with', '$Content-Type', '')
    )
)));

// SIGNATURE
// A base64-encoded HMAC hashed signature with your secret key.
// This is used so Amazon can verify your request, and will be
// passed along in a POST field later.
$signature = hash_hmac('sha1', $policy, $secretKey, true);
$signature = base64_encode($signature);

// CURL
// Pass in the full URL to your Amazon bucket. Set
// RETURNTRANSFER and HEADER true to see the full response from
// Amazon, including body and head. Set POST fields for cURL.
// Execute the cURL request.
$url = 'https://' . $bucket . '.s3-' . $region . '.amazonaws.com';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, array(
    'key' => $fileName,
    'AWSAccessKeyId' =>  $accessKeyId,
    'acl' => $acl,
    'policy' =>  $policy,
    'Content-Type' =>  $fileType,
    'signature' => $signature,
    'file' => new CurlFile(realpath($filePath), $fileType, $fileName)
));
$response = curl_exec($ch);

// RESPONSE
// If Amazon returns a response code of 204, the request was
// successful and the file should be sitting in your Amazon S3
// bucket. If a code other than 204 is returned, there will be an
// XML-formatted error code in the body. For simplicity, we use
// substr to extract the error code and output it.
if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 204) {
    echo 'Success!';
} else {
    $error = substr($response, strpos($response, '<Code>') + 6);
    echo substr($error, 0, strpos($error, '</Code>'));
}
$return_url = $url . '/' . $fileName;

return $return_url;
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