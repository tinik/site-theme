<?php get_header(); ?>
<?php dynamic_sidebar('widgets_header'); ?>

<div class="row">
    <div class="large-12 columns" role="content">
        <h1 align="center" style="font-size:74px">202 + 202 = 404</h1>
        <h2 align="center" style="font-size:24px"><?php _e('NOT FOUND PAGE'); ?></h2>
        <p align="center"><?php _e('Страница, которую вы ищете, возможно, была удалена, переименована, или она временно недоступна.', 'ntishchuk'); ?></p>
    </div>
</div>

<?php get_footer(); ?>