<?php $social = get_option('social'); ?>
<?php if($social): ?>
<div class="social">
    <?php foreach($social as $key=>$item): ?>
        <?php if($item): ?>
            <a href="<?php echo $item; ?>" title="<?php echo $key; ?>"><!--
                 --><img width="32" src="<?php printf('%s/assets/img/social/%s.png', get_template_directory_uri(), $key); ?>" /><!--
             --></a>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>