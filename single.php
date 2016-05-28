<?php
get_header();
dynamic_sidebar('widgets_header');
?>
<div class="wrapper">
    <div class="row">
        <div class="large-9 columns">
            <div id="post-area">
            <?php if (have_posts()): ?>
                <?php the_post(); ?>
                <?php $id = get_the_ID(); ?>
                <article id="post-<?php echo $id; ?>" <?php post_class(); ?>>
                    <h3><?php the_title(); ?></h3>
                    <?php
                    if(is_user_logged_in() && current_user_can('edit_post', $id)):
                        $link = get_edit_post_link($id);
                        echo sprintf('<a href="%s" class="fa fa-edit"> %s</a>', $link, _('Edit'));
                    endif;
                    ?>
                    <div class="meta_data">
                        <a href="<?php echo get_permalink(); ?>">
                            <?php the_time(get_option('date_format')); ?>
                        </a>
                    </div>
                    <p class="post-category"><?php the_category(', ') ?></p>
                    <div class="custom-content">
                        <?php if(has_post_thumbnail()): ?>
                            <div class="custom-image"><?php the_post_thumbnail('stumblr-large-image'); ?></div>
                        <?php endif; ?>
                        <?php the_content(); ?>
                    </div>
                    <div class="tags"><?php get_theme_custom_tags(); ?></div>
                    <br />
                    <div class="row nearest">
                        <div class="large-6 columns">
                            <?php $previous_post = get_previous_post(); ?>
                            <?php if(!empty($previous_post)): ?>
                                <a class="prev left" href="<?php echo get_permalink($previous_post->ID ); ?>">
                                    <?php _e('Предедущая статья', 'ntishchuk'); ?>
                                    <span class="sub-title-post"><?php echo $previous_post->post_title; ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="large-6 columns">
                            <?php $next_post = get_next_post(); ?>
                            <?php if (!empty($next_post)): ?>
                                <a class="next right" href="<?php echo get_permalink( $next_post->ID ); ?>">
                                    <?php _e('Следующая статья', 'ntishchuk'); ?>
                                    <span class="sub-title-post"><?php echo $next_post->post_title; ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
               </article>
               <!-- end post -->
            <?php endif; ?>
            </div>
        </div>
        <?php get_sidebar('right'); ?>
    </div>
</div>
<?php get_footer(); ?>
