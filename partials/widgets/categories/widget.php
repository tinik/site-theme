<?php echo $vars['before_widget']; ?>
    <div class="theme-widget category">
        <?php if(!empty($vars['showTitle']) && $vars['showTitle'] == 'Yes' && !empty($vars['title'])): ?>
            <h2><?php echo $vars['title']; ?></h2>
        <?php endif; ?>

        <?php if(!empty($vars['categories'])): ?>
            <ul class="side-nav">
            <?php foreach($vars['categories'] as $category): ?>
                <li>
                    <a href="<?php echo get_category_link($category->term_id) ?>"><?php echo $category->name; ?></a>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php echo $vars['after_widget']; ?>