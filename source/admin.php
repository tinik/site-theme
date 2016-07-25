<?php

use Fields\FieldFactory;

add_action('init', function() {
    $meta = new Options\OptionBox('meta', 'Head Code Insertion');
    $meta->add('head_code', 'Code', [
        'field' => FieldFactory::create('textarea', null, [
            'attributes' => ['rows' => 7, 'cols'=>50]
        ]),
    ]);

    $logo = new Options\OptionBox('logo', 'Site Logo');
    $logo->add('icon', 'Icon', [
        'field' => FieldFactory::create('image'),
    ]);
    $logo->add('image', 'Site logo image', [
        'field' => FieldFactory::create('image'),
    ]);

    $linkOptions = [
        'bitbucket' => ['Bitbucket', 'fa-bitbucket-square'],
        'github'    => ['Github',    'fa-github-square'],
        'linkedin'  => ['LinkedIn',  'fa-linkedin-square'],
        'google'    => ['Google+',   'fa-google-plus-square'],
        'facebook'  => ['Facebook',  'fa-facebook-square'],
        'twitter'   => ['Twitter',   'fa-twitter-square'],
    ];

    $links = new Options\OptionBox('links', 'Links');
    foreach($linkOptions as $key=>$value) {
        $field = FieldFactory::create('text', null, [
            'attributes' => ['size' => 50]
        ]);

        $links->add($key, $value[0], [
            'field' => $field,
            'title' => $value[0],
            'icon'  => $value[1],
        ]);
    }

    $options  = new \Admin\Options('theme_options', 'Theme Options', 'themes.php');
    $options->add_box($meta);
    $options->add_box($logo);
    $options->add_box($links);
});

add_action('admin_init', function() {
    if(!is_plugin_active('siteorigin-panels/siteorigin-panels.php')) {
        add_action('admin_notices', function() {
            $type = 'error';
            $message = _('Plugin "siteorigin-panels" is not active.');

            Helpers\Message::admin($type, $message);
        });
    }

    // SCRIPT
    wp_enqueue_script('script_theme', assets_uri('js/admin.js'), [], '0.1.1', true);
});

