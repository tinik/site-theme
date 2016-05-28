<?php get_header(); ?>
<?php dynamic_sidebar('widgets_header'); ?>

    <div class="wrapper">
        <?php do_action('build_search_page'); ?>
    </div>

<?php get_footer(); ?>