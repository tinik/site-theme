<% _.each(results, function(item, index) { %>
    <div class="group" data-index="<%= index %>">
        <h3><?php _e('Field element'); ?></h3>
        <div>
            <label><?php _e('Keyword:'); ?></label>
            <input class="widefat" data-id="keyword" name="<?php echo $this->get_field_name('accordion[<%=index%>][keyword]'); ?>" type="text" value="<%= item.keyword %>" />
        </div>
        <div>
            <label><?php _e('Label:'); ?></label>
            <input class="widefat" data-id="label" name="<?php echo $this->get_field_name('accordion[<%=index%>][label]'); ?>" type="text" value="<%= item.label %>" />
        </div>
        <div>
            <label><?php _e('Content:'); ?></label>
            <textarea class="widefat" data-id="content" cols="15" rows="5" name="<?php echo $this->get_field_name('accordion[<%=index%>][content]'); ?>"><%= item.content %></textarea>
        </div>
        <div class="actions">
            <input type="button" class="button button-link delete" data-id="<%= index %>" value="<?php _e('Delete'); ?>" />
        </div>
    </div>
    <hr />
<% }); %>