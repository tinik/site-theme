<!doctype html>
<html <?php if(is_user_logged_in()): language_attributes(); endif; ?>>
<head>
    <title><?php wp_title(' ', true, '/'); ?></title>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <meta name="google-site-verification" content="CR8p9SgS8tcbKdqQXT1NFzSYzZG9oc1hrD-rtWhKKHU" />
    <meta name=viewport content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>