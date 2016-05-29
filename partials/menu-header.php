<nav class="top-bar" data-topbar role="navigation" data-options="sticky_on: large">
    <ul class="title-area">
        <li class="name">
            <h1>
                <a href="<?php echo get_home_url(); ?>">
                    <?php _e('Home', 'ntishchuk'); ?>
                </a>
            </h1>
        </li>
        <li class="toggle-topbar menu-icon">
            <a href="javascript:void(0);"><span><?php _e('Menu', 'ntishchuk'); ?></span></a>
        </li>
    </ul>

    <section class="top-bar-section"><?php echo $output; ?></section>
</nav>