<?php
$title = '';
if (isset($vars['title'])):
    $title = $vars['title'];
endif;

$showTitle = null;
if (isset($vars['showTitle']) && $vars['showTitle'] == 'Yes'):
    $showTitle = $vars['showTitle'];
endif;
?>
<p>
    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>
<p>
    <input name="<?php echo $this->get_field_name('showTitle'); ?>" type="hidden" value="No" />
    <input class="checkbox" id="<?php echo $this->get_field_id('showTitle'); ?>" name="<?php echo $this->get_field_name('showTitle'); ?>" type="checkbox" value="Yes" <?php if($showTitle == 'Yes') echo 'checked="checked"'; ?> />
    <label for="<?php echo $this->get_field_id('showTitle'); ?>"><?php _e('Show Title'); ?></label>
</p>