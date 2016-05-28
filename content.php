<?php $post = get_post(); ?>
<?php $id = $post->ID; ?>
<div id="post-<?php echo $id; ?>" <?php post_class('row post', $id); ?>>
    <div class="large-2 columns">
        <p class="post-date">
            <span class="post-day"><?php echo get_the_time('d', $post); ?></span>
            <span class="post-month"><?php echo get_the_time('M', $post); ?></span>
        </p>
    </div>
    <div class="large-10 columns delimiter">
        <h3 class="subheader">
            <i class="fa fa-external-link"></i>&nbsp;<a href="<?php the_permalink() ?>"><?php
                echo get_the_title($post);
            ?></a>
        </h3>
        <?php
        if(is_user_logged_in() && current_user_can('edit_post', $id)):
            $link = get_edit_post_link($id);
            echo sprintf('<a href="%s" class="fa fa-edit"> %s</a>', $link, _('Edit'));
        endif;
        ?>
        <div class="content"><?php echo get_the_content(''); ?></div>
    </div>
</div>
