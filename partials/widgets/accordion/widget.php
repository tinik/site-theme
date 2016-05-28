<?php $index = $vars['index']; ?>
<?php echo $vars['before_widget']; ?>
<h4><?php echo $vars['title']; ?></h4>
<dl class="accordion skills" data-accordion="">
    <?php if(!empty($vars['accordion'])): ?>
        <?php reset($vars['accordion']); ?>
        <?php $needle = key($vars['accordion']); ?>
        <?php foreach ($vars['accordion'] as $key => $item): ?>
        <?php $keyname = sprintf('%s%s', $index, $key); ?>
        <dd>
            <a href="#<?php echo $keyname; ?>"><strong><?php echo $item['label']; ?></strong></a>
            <div id="<?php echo $keyname; ?>" class="content <?php echo ($needle==$key?'active':'') ?>"><?php echo $item['content']; ?></div>
        </dd>
        <?php endforeach; ?>
    <?php endif ?>
</dl>
<?php echo $vars['after_widget']; ?>