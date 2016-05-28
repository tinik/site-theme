<?php

add_action('admin_menu', function() {
    // Add menu page
    add_theme_page('Theme Options', 'Theme Options', 'administrator', 'custom_admin', function() {
        return get_template_part('partials/admin/theme-options');
    });
});

add_action('admin_notices', function() {
    // Admin updated
    if (!empty($_REQUEST['settings-updated'])) {
        echo '<div class="updated"><p>'. _('Updated theme options') .'</p></div>';
    }
});

add_action('admin_init', function() {
    // SETTINGS
    register_setting('custom_theme_options', 'social', function($plugin_options) {
        return $plugin_options;
    });

    // CSS
    wp_enqueue_style('css_options', assets_uri('css/admin/options.css'));
});
