<div class ="wrap">
<h1><?php 
$action = $_GET['action'];
if($action == 'view'){    
    _e('View Article &nbsp', 'art');
}elseif($action == 'edit'){
    _e('Edit Article &nbsp', 'art');
}
?>
 <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=article'); ?>"><?php _e('Back to List', 'art')?></a>
 </h1>

<?php 

$id = $_GET['id'];
$isNew = $id == 0? true: false;
if(!$isNew){
    $item = get_article_by_id($id);
    $Categorys = get_all_categorys();
}
?>
<input type="hidden" name="label" id="label" value="" />
 <form action="" method="post" enctype="multipart/form-data">
    <table class="form-table">
        <tbody>
        <tr class="row-title">
                <th scope="row">
                    <label for="title"><?php _e('Title : ', 'art'); ?></label>
                </th>
                <td colspan="2"><?php 
                    if($action == 'view'){
                        
                ?>
                    <input type="text" name="title" id="title" class="regular-text" placeholder="<?php echo esc_attr('Title', 'art'); ?>" value="<?php echo ($isNew ? '' : esc_attr($item->title)); ?>" readonly/>
                    <?php }
                    else if($action == 'edit'){
                        ?>
                       <input type="text" name="title" id="title" class="regular-text" placeholder="<?php echo esc_attr('Title', 'art'); ?>" value="<?php echo ($isNew ? '' : esc_attr($item->title)); ?>"/>
                    <?php } ?>
                </td>
            </tr>
            <tr class="row-description">
                <th scope="row">
                    <label for="description"><?php _e('Description : ', 'art'); ?></label>
                </th>
                <td colspan="2"><?php 
                    if($action == 'view'){
                        
                ?>
                    <textarea name="description" id="description" class="regular-text" placeholder="description" rows="3" cols="30" readonly><?php echo ($isNew ? '' : esc_attr($item->description)); ?></textarea>
                    <?php }
                    else if($action == 'edit'){
                        ?>
                        <textarea name="description" id="description" class="regular-text" placeholder="description" rows="3" cols="30"><?php echo ($isNew ? '' : esc_attr($item->description)); ?></textarea>
                    <?php } ?>
                </td>
            </tr>
            <tr class="row-url_file">
                    <th scope="row">
                        <label for="url_file"><?php _e('Image :', 'adm'); ?></label>
                    </th>
                    <td>
                        <?php
                            if($item->url_file != null || $item->url_file != ''){
                                echo "<img style='height:300px; width:300px; padding-left:21px;' src='$item->url_file' />";
                            }
                        ?>                      
                        <input type="file" name="url_file" id="url_file" class="regular-text" style="width:225px;" placeholder="<?php echo esc_attr('Choose Image..', 'scdl'); ?>" accept="image/png, image/jpg, image/jpeg" onchange="return checkImage();" />
                        <br><span style="font-size:8pt"><strong>Note :</strong> only *.jpeg, *.jpg, and *.png file type can be supported.</span>
                    </td>
            </tr>
            <tr class="row-time">
                <th scope="row">
                    <label for="time"><?php _e('Time : ', 'art'); ?></label>
                </th>
                <td colspan="2"><?php 
                    if($action == 'view'){
                        
                ?>
                    <input type="text" name="time" id="time" class="regular-text" placeholder="<?php echo esc_attr('Time', 'art'); ?>" value="<?php echo ($isNew ? '' : esc_attr($item->time)); ?>" readonly/>
                    <?php }
                    else if($action == 'edit'){
                        ?>
                       <input type="text" name="time" id="stage_timename" class="regular-text" placeholder="<?php echo esc_attr('Time', 'art'); ?>" value="<?php echo ($isNew ? '' : esc_attr($item->time)); ?>"/>
                    <?php } ?>
                </td>
            </tr>
            <tr class="row-category_travel">
                    <th scope="row">
                        <label for="category_travel"><?php _e('Category :', 'art'); ?></label>
                    </th>
                    <td>
                    <?php 
                    $itemCategorys = json_decode($item->category_travel);
                    $is_val = isset($item) && count($itemCategorys) > 0;
                    foreach ($Categorys as $key => $val) { 
                        $isChecked = $is_val ? array_search($val->id, $itemCategorys) : false;
                        $status = ($isChecked === false ? "" : " checked='checked' ");
                        if ($key % 2 == 0) {
                            if ($key != 0) {
                                echo "</tr>";    
                            }
                            echo "<tr>";
                        }
                        if($action == 'view'){
                            echo "<td><input type='checkbox' id='category_travel_{$val->id}' name='category_travel[]' class='category_travel' value='{$val->id}' {$status} disabled readonly><label>{$val->category_name}</label></td>";
                        }else{
                            echo "<td><input type='checkbox' id='category_travel_{$val->id}' name='category_travel[]' class='category_travel' value='{$val->id}' {$status}><label>{$val->category_name}</label></td>";
                        }
                        
                    }
                    echo "</tr>";
                ?>
                    </td>
                </tr>
            <td></td>
                 <?php if($action == 'edit'){ ?>
                <td style="float: center; padding-right: 30px;">
                <?php wp_nonce_field('article-new'); ?>
                <?php submit_button(__('Save', 'art'), 'primary', 'submit_article'); ?>
                </td>
                 <?php }?>
            </tr> 
        </tbody>
    </table>
    <input type="hidden" name="field_id" value="0">
    </form>
 </div>
 <script>
      CKEDITOR.replace('description' , {
        toolbarGroups: [
            { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
            { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
            { name: 'forms', groups: [ 'forms' ] },
            '/',
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
            { name: 'links', groups: [ 'links' ] },
            { name: 'insert', groups: [ 'insert' ] },
            '/',
            { name: 'styles', groups: [ 'styles' ] },
            { name: 'colors', groups: [ 'colors' ] },
            { name: 'tools', groups: [ 'tools' ] },
            { name: 'others', groups: [ 'others' ] },
            { name: 'about', groups: [ 'about' ] }
        ],
        removeButtons: 'Image,Smiley,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Language,Flash'
    });
 </script>