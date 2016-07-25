<?php $box = \Options\OptionBox::get('links'); ?>
<?php if($box): ?>
    <?php
    $options = [];
    foreach($box->get_options() as $name => $item):
        $value = $item->get_value();
        if(!empty($value)):
            $options[] = [
                'link'  => $value,
                'title' => $item->get_params('title'),
                'icon'  => $item->get_params('icon'),
            ];
        endif;
    endforeach;

    deb
    ?>
    <?php if($options): ?>
        <div class="social menu-centered">
            <ul class="menu inline-list simple">
                <?php foreach($options as $item): ?>
                    <li>
                        <a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>">
                            <i class="fa <?php echo $item['icon']; ?>"></i>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
<?php endif; ?>
