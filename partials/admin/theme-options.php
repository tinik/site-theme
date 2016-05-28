<?php
    $social = get_option('social');
    $options = [
        'bitbucket' => 'Bitbucket',
        'github'    => 'Github',
        'linkedin'  => 'LinkedIn',
        'google'    => 'Google+',
        'facebook'  => 'Facebook' ,
        'twitter'   => 'Twitter',
    ];
?>
<div class="wrap">
    <!-- themes.php?page=custom_admin -->
    <form method="post" action="options.php" enctype="multipart/form-data">
        <?php settings_fields('custom_theme_options'); ?>
        <div class="icon32" id="icon-tools"></div>
        <h2><?php _e('Theme Options'); ?></h2>
        <table class="form-table social">
            <?php foreach($options as $key=>$title): ?>
                <?php $value='';?>
                <?php if(!empty($social[$key])) $value = $social[$key]; ?>
                <tr valign="top">
                    <td><?php echo $title; ?></td>
                    <td>
                        <input type="text" size="50" name="social[<?php echo $key; ?>]" value="<?php echo $value; ?>" />
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save'); ?>" />
        </p>
    </form>
</div>