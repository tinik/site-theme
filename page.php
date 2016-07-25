<?php

get_header();
dynamic_sidebar('widgets_header');

print '<div class="wrapper">';
    the_content();
print '</div>';

get_footer();