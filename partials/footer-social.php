<?php $social = get_option('social'); ?>
<?php if($social): ?>
<div class="social">
    <?php foreach($social as $key=>$item): ?>
        <?php if($item): ?>
        <a href="<?php echo $item; ?>" title="<?php echo $key; ?>">
            <img width="32" src="<?php assets_uri(sprintf('img/social/%s.png', $key), true); ?>" />
        </a>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>