<?php $query = (string)(!empty($vars['query'])?$vars['query']:null); ?>
<div class="search-content">
    <?php if(!empty($vars['posts'])): ?>
        <?php if($query): ?>
            <h2><?php _e('Результат поиска', 'ntishchuk'); ?></h2>
            <!-- <?php echo $query; ?> -->
        <?php endif; ?>

        <ul class="no-bullet">
            <?php echo join('', array_map(function($value) {
                return sprintf('<li><a href="%s">%s</a></li>', $value['link'], $value['title']);
            }, $vars['posts'])); ?>
        </ul>
        <?php custom_pagination() ?>
    <?php else: ?>
        <br />
        <p class="text-center"><?php printf(__('По запросу <b>%s</b> ничего не найдено.', 'ntishchuk'), $query); ?></p>
    <?php endif; ?>
</div>
