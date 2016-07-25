<?php $query = $vars['query']; ?>
<form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
    <div class="input-group">
        <input name="s" type="text" class="input-group-field" placeholder="<?php _e('Искать'); ?>" value="<?php echo $query; ?>" />
        <div class="input-group-button">
            <input type="submit" class="button" value="<?php _e('Go'); ?>">
        </div>
    </div>
</form>
<?php do_action('search_result', ['query' => $query]); ?>