<?php

use Helpers\Message;

add_action('admin_init', function() {
    if(!is_plugin_active('siteorigin-panels/siteorigin-panels.php')) {
        add_action('admin_notices', function() {
            $type = 'error';
            $message = _('Plugin "siteorigin-panels" is not active.');

            Message::admin($type, $message);
        });
    }

    // SETTINGS
    register_setting('custom_theme_options', 'social', function($plugin_options) {
        return $plugin_options;
    });

    // STYLE
    wp_enqueue_style('style_options', assets_uri('css/admin/options.css'));

    // SCRIPT
    wp_enqueue_script('script_theme', assets_uri('js/admin.js'), [], '0.1.1', true);
});

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
