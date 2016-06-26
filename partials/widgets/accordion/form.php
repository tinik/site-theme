<?php
$title = (!empty($vars['title']))?$vars['title']:'';
if(empty($vars['accordion'])):
    $vars['accordion'] = [];
endif;
?>
<div class="widget accordion" id="<?php echo $this->id; ?>">
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" />
    </p>
    <div id="accordion">
        <div class="wrap"></div>
        <div class="actions">
            <input type="button" class="create button button-primary" value="<?php _e('ADD'); ?>" />
        </div>
        <br />
        <script type="text/template"><?php $this->partial(); ?></script>
    </div>

    <script type="text/javascript">
    jQuery(document).ready(function() {
        new Accordion({
            'id'   : '<?php echo $this->id; ?>',
            'data' : <?php echo wp_json_encode($vars['accordion']); ?>
        });
    });
    </script>
</div>