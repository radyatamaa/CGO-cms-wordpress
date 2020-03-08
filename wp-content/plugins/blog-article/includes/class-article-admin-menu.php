<?php 
/**
 *  Admin Menu
 */


class Article_admin_menu
{

    /**
     *  Kick-in the class
     */
    public function __construct()
    {
        add_action('admin_menu', array($this,'admin_menu'));
    }
/**
 * Add menu items
 * 
 * @return void
 */
public function admin_menu()
{

 /** Top Menu **/
 $hook = add_menu_page(__('Article' , 'art'),__('Article', 'art'), 'activate_plugins', 'article', array ($this,'plugin_page'), 'dashicons-id', null);

 add_submenu_page('article', __('Article List', 'art'), __('Article List', 'art'), 'activate_plugins', 'article', array($this, 'plugin_page'));

 add_submenu_page('article', __('Create Article', 'art'), __('Create Article', 'art'), 'activate_plugins', 'article&action=new', array($this, 'plugin_page'));

if (!isset($_REQUEST['action']) || $_REQUEST['action'] == 'delete') add_action("load-$hook", 'article_page_add_option');

}

/**
 * Handles the plugins page
 * 
 * @return void
 */

public function plugin_page(){
    $page = $_GET['page'];
    $action = isset($_REQUEST['action']) ? $_REQUEST ['action'] : 'list';
    $id = isset($_GET['id']) ? intval($_GET['id']) :0;
    $ids ='';

    if (isset($_REQUEST['s']) && !empty($_REQUEST['s'])){
        $_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'].'&s'. $_REQUEST['s'];
    }

    if(isset($_REQUEST['sr']) && !empty($_REQUEST['sr'])){
        $_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] . '&sr=' . $_REQUEST['sr'];
    }

    if (isset($_REQUEST['s']) && empty($_REQUEST['s']) 
        && isset($_REQUEST['sr']) && empty($_REQUEST['sr'])) {
            $parsed_url = parse_url($_SERVER['REQUEST_URI']);
            parse_str($parsed_url['query'], $parsed_query);
            unset($parsed_query['s'],$parsed_query['sr'], $parsed_query['paged']);
            $parsed_url['query'] = http_build_query($parsed_query);
            $_SERVER['REQUEST_URI'] = unparse_url($parsed_url);
        }

    switch($action){
        case 'view':
        $template = dirname(__FILE__).'/views/article-single.php';
        break;

        case 'edit':
        $template = dirname(__FILE__).'/views/article-single.php';
        break;

        case 'new':
        $template = dirname(__FILE__). '/views/article-new.php';
        break;

        case 'delete':
        delete_article($id);
        echo "<script>window.location='" . get_admin_url(get_current_blog_id(), 'admin.php?page=' . $page) . "'</script>";
        $template = '';
        break;

        default:
        $template = dirname(__FILE__).'/views/article-list.php';
        break;
    
    }

    if (file_exists($template)){
        include $template;
     }

    }

}


function article_page_set_option($status, $option, $value)
{
    if('per_page' == $option) return $value;

    return $status;
}

function article_page_add_option(){
    $option = 'per_page';

    $args = array(
        'label' => 'Rows: ',
        'default' => 20,
        'option' => 'per_page'
    );
    add_screen_option($option, $args);
    
}

function article_search_filter($query){
    if (!is_admin() && $query->is_main_query()) {
        if($query->is_search){
           $query->set('post_type', 'article');
           $query->set('posts_per_page', 'article_posts_per_page');
        }
    }
}

// add_action('pre_get_posts', 'article_search_filter');

add_filter('set-screen-option', 'article_page_add_option', 10 , 3);