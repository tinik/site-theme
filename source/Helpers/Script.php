<?php

namespace Helpers;

class Script
{
    /**
     * Enqueue inline script for admin panel
     *
     * @param string $handle unique key
     * @param string $source JavaScript source
     */
    public static function enqueue_admin_inline_script($handle, $source)
    {
        wp_enqueue_script($handle, 'http://', [], false, true);
        $source = preg_replace(['#<script(.*?)>#is', '#</script>#is'], '', $source);
        add_action('admin_footer', function() use($handle, $source) {
            global $wp_scripts;
            $wp_scripts->add_data($handle, 'data', $source);
        });
    }
}