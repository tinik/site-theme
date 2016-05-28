<?php get_header(); ?>
<?php dynamic_sidebar('widgets_header'); ?>

<div class="wrapper">
    <div class="row">
        <div class="large-9 columns">
            <?php $category = get_category(get_query_var('cat')); ?>
            <h1 class="title">
                <i class="fa fa-caret-right"></i>
                <?php _e('Категория:', 'ntishchuk'); echo ' ', $category->name; ?>
            </h1>
            <?php edit_post_link(__(' Edit', 'ntishchuk'), null, null, null, 'fa fa-edit'); ?>
            <?php if($category->category_description): ?>
                <p><?php echo $category->category_description; ?></p>
            <?php endif; ?>

            <?php if (have_posts()): ?>
                <ul class="no-bullet">
                <?php while(have_posts()): the_post(); ?>
                    <li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
                <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
        <?php get_sidebar('right'); ?>
    </div>
</div>

<?php get_footer(); ?>