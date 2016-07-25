<div class="top-bar">
    <div class="top-bar-title">
        <span data-responsive-toggle="responsive-menu" data-hide-for="medium" class="hide-for-large">
            <button class="menu-icon" type="button" data-toggle></button>
        </span>

        <a class="show-for-medium" href="<?php echo get_home_url(); ?>"><?php _e('Home', 'ntishchuk'); ?></a>
    </div>

    <div id="responsive-menu">
        <div class="top-bar-right">
            <?php echo $output; ?>
        </div>
    </div>
</div>

