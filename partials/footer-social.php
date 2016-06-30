<?php $social = get_option('social'); ?>
<?php if($social): ?>
<div class="clearfix social">
    <ul class="inline-list right">
        <?php foreach($social as $key=>$item): ?>
            <?php if($item && !empty($item)): ?>
            <li>
            <a href="<?php echo $item; ?>" title="<?php echo $key; ?>">
                <img width="32" src="<?php assets_uri(sprintf('img/social/%s.png', $key), true); ?>" />
            </a>
            </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
