<div class="wrap">
    <h2><?php _e('Article', 'art'); ?> <a href="<?php echo admin_url('admin.php?page=article&action=new'); ?>" class="add-new-h2"><?php _e('Add New', 'art');?></a><h2>

    <?php 
    $error = isset($_GET['error']) ? $_GET['error'] : null;
    if(!empty($error)){
        $error = str_replace('_', ' ', $error);
        echo "<div class='error notice'><p>{$error}</p></div>";
    }

    $message = isset($_GET['message']) ? $_GET['message']: null;
    if(!empty($message)){
        $message = str_replace('_', ' ', $message);
        echo "<div class='updated notice'><p>{$message}</p></div>";
    }
    ?>

    <form method="post">
        <input type="hidden" name="page" value="article" >
        
        <?php
            $list_table = new art_article_list_table('article');
            $list_table->prepare_items();
            ?>
            <?php $list_table->search_box('Search', 'art');
            $list_table->display(); ?>
    </form>
</div>

<script>
function validate()
{
	return confirm("Are you sure you want to delete?");	
}
</script>