<?php

get_header();

    dynamic_sidebar('widgets_header');

    if (have_posts()):
        print '<div class="wrapper">';
        while(have_posts()): the_post();
            get_template_part('content', get_post_format());
        endwhile;
        print '</div>';
    endif;

get_footer();