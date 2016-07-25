<?php echo $vars['before_widget']; ?>
    <div class="theme-custom-posts"><?php
    if(have_posts()):
        while(have_posts()):
            the_post();
            get_template_part('content');
        endwhile;

        echo '<br />';

        create_pagination($vars['query'], $vars['paged']);
    endif;
    ?></div>
<?php echo $vars['after_widget']; ?>