<div class ="wrap">
<h1><?php _e('Create Article &nbsp', 'art');
?>
 <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=article'); ?>"><?php _e('Back to List', 'art')?></a>
 </h1>

<?php 
  $Categorys = get_all_categorys();
?>
<input type="hidden" name="label" id="label" value="" />
 <form action="" method="post" enctype="multipart/form-data">
    <table class="form-table">
        <tbody>
        <tr class="row-title">
                <th scope="row">
                    <label for="title"><?php _e('Title : ', 'art'); ?></label>
                </th>
                <td colspan="2">
                    <input type="text" name="title" id="title" class="regular-text" placeholder="<?php echo esc_attr('Title', 'art'); ?>" value=""/>                 
                </td>
            </tr>
            <tr class="row-description">
                <th scope="row">
                    <label for="description"><?php _e('Description : ', 'art'); ?></label>
                </th>
                <td colspan="2">
                    <textarea name="description" id="description" class="regular-text" placeholder="description" rows="3" cols="30"></textarea>
                  
                </td>
            </tr>
            <tr class="row-url_file">
                    <th scope="row">
                        <label for="url_file"><?php _e('Image :', 'adm'); ?></label>
                    </th>
                    <td>                   
                        <input type="file" name="url_file" id="url_file" class="regular-text" style="width:225px;" placeholder="<?php echo esc_attr('Choose Image..', 'scdl'); ?>" accept="image/png, image/jpg, image/jpeg" onchange="return checkImage();" />
                        <br><span style="font-size:8pt"><strong>Note :</strong> only *.jpeg, *.jpg, and *.png file type can be supported.</span>
                    </td>
            </tr>
            <tr class="row-time">
                <th scope="row">
                    <label for="time"><?php _e('Time : ', 'art'); ?></label>
                </th>
                <td colspan="2">
                    <input type="text" name="time" id="stage_timename" class="regular-text" placeholder="<?php echo esc_attr('Time', 'art'); ?>" value=""/>                  
                </td>
            </tr>
            <tr class="row-category_travel">
                    <th scope="row">
                        <label for="category_travel"><?php _e('Category :', 'art'); ?></label>
                    </th>
                    <td>
                    <?php 
                    foreach ($Categorys as $key => $val) { 
                        if ($key % 2 == 0) {
                            if ($key != 0) {
                                echo "</tr>";    
                            }
                            echo "<tr>";
                        }
                        echo "<td><input type='checkbox' id='category_travel_{$val->id}' name='category_travel[]' class='category_travel' value='{$val->id}'><label>{$val->category_name}</label></td>";
                    }
                    echo "</tr>";
                ?>
                    </td>
                </tr>
            <td></td>
                <td style="float: center; padding-right: 30px;">
                <?php wp_nonce_field('article-new'); ?>
                <?php submit_button(__('Add', 'art'), 'primary', 'submit_article'); ?>
                </td>
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
