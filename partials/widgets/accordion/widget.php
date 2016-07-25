<?php $index = $vars['index']; ?>
<?php echo $vars['before_widget']; ?>
<h4><?php echo $vars['title']; ?></h4>
<ul class="accordion" data-accordion data-allow-all-closed="true">
    <?php if(!empty($vars['accordion'])): ?>
        <?php reset($vars['accordion']); ?>
        <?php $needle = key($vars['accordion']); ?>
        <?php foreach ($vars['accordion'] as $key => $item): ?>
        <?php $keyname = sprintf('%s%s', $index, $key); ?>
        <li class="accordion-item" data-accordion-item>
            <a class="accordion-title" href="#<?php echo $keyname; ?>"><?php echo $item['label']; ?></a>
            <div class="accordion-content" data-tab-content>
                <?php echo $item['content']; ?>
            </div>
        </li>
        <?php endforeach; ?>
    <?php endif ?>
</dl>
<?php echo $vars['after_widget']; ?>