<?php $query = $vars['query']; ?>
<form role="search" method="get" id="searchform" class="searchform" action="<?php echo home_url('/'); ?>">
    <div class="row collapse">
        <div class="small-10 columns">
            <input name="s" id="s" type="text" placeholder="<?php _e('Искать', 'ntishchuk'); ?>" value="<?php echo $query; ?>" />
        </div>
        <div class="small-2 columns">
            <button type="submit" class="button postfix"><?php _e('Go', 'ntishchuk'); ?></button>
        </div>
    </div>
</form>
<?php do_action('search_result', ['query' => $query]); ?>