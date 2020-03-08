<?php

defined('ABSPATH') or die();
/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Article_Form_Handler
{

    public function __construct()
    {
        add_action('admin_init', array($this, 'handle_form'));
    }
/**
 * Handle the audition event new and edit form
 *
 * @return void
 */

    public function handle_form()
    {
        if (!isset($_POST['submit_article'])) {
            return;
        }

        // if (!wp_verify_nonce($_POST['_wpnonce'], 'audition-event-new')) {
        //     die(__('Are you cheating?', 'avt'));
        // }

        // if (!current_user_can('read')) {
        //     wp_die(__('Permission Denied!', 'avt'));
        // }

        $error = array();
        $page_url = admin_url('admin.php?page=article');

        $page = isset($_POST['page']) ? sanitize_text_field($_POST['page']) : '';

        $field_id = isset($_GET['id']) ?intval($_GET['id']) : 0;
        $title = isset($_POST['title']) ? stripslashes(sanitize_text_field( $_POST['title'] )) : '';
        $description = isset($_POST['description']) ? stripslashes(sanitize_text_field( $_POST['description'] )) : '';
        $category = isset($_POST['category_travel']) ? json_encode($_POST['category_travel']) : '';
        $time = isset($_POST['description']) ? stripslashes(sanitize_text_field( $_POST['time'] )) : '';
        $file = file_exists($_FILES['url_file']['tmp_name']) ? $_FILES["url_file"] : '';
        $user = wp_get_current_user();
        
        if ($file !== '') $imagePath = upload_image_s3('blog');

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        //some basic validation
        // if (!$event_id) {
        //     $error[] = __('Error : Event is required', 'avt');
        // }

        // if (!$name) {
        //     $error[] = __('Error : Name is required', 'avt');
        // }

        // if (!$description) {
        //     $error[] = __('Failed : description  cannot be empty', 'avt');
        // }
        // if (strlen($description) < 4) {
        //     $error[] = __('Failed : description must be more than 3 character', 'avt');
        // }

        //bail out if error found
        if ($error) {
            $first_error = reset($error);
            $error = str_replace(' ', '_', $first_error);
            $redirect_to = add_query_arg(array('error' => $error), $page_url);
            wp_safe_redirect($redirect_to);
            exit;
        }

        $fields = array(
            'title' => $title,
            'description' => $description,
            'category_travel' => $category,
            'time' => $time,
            'url_file' =>  isset($imagePath) ? strval($imagePath) : '#',
        );

        //New or Edit
        if (!$field_id) {
            $insert_id = create_article($fields);
        } else {
            $fields['id'] = $field_id;
            $insert_id = update_article($fields);
        }

        if (is_wp_error($insert_id)) {
            $error_codes =
            $insert_id->get_error_messages();
            $first_error = reset($error_codes);
            $error = str_replace(' ', '_', $first_error);
            $redirect_to = add_query_arg(array('error' => $error), $page_url);
        } else {
            $redirect_to = add_query_arg(array('message' => 'Success!'), $page_url);
        }
        wp_safe_redirect($redirect_to);
        exit;

    }
}

new Article_Form_Handler();
