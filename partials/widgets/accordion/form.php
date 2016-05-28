<?php
$title = (!empty($vars['title']))?$vars['title']:'';
if(empty($vars['accordion']))
    $vars['accordion'] = [];
?>
<p>
    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
    <input class="widefat" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" />
</p>
<div id="accordion">
    <div class="wrap"></div>
    <div class="actions">
        <input type="button" class="create button button-primary" value="<?php _e('ADD'); ?>" />
    </div>
</div>

<script type="text/template" id="template">
<?php include \Helpers\Template::locate('partials/widgets/accordion/template'); ?>
</script>

<script type="text/javascript">
!function($) {
    var Model = Backbone.Model.extend({
        defaults: {
            keyword : '',
            label   : '',
            content : '',
        },
    });

    var Accordion = Backbone.Collection.extend({
        model:Model,
    });

    var View = Backbone.View.extend({
        el: "#accordion",
        template: _.template($("#template").html()),
        events : {
            'click input[type="button"].create':'addOne',
            'click input[type="button"].delete':'remove',
        },
        initialize: function() {
            console.log('View initialized...');
            console.log(this.collection);

            this.collection.on('add',    this.render, this);
            this.collection.on('remove', this.render, this);
        },
        addOne: function() {
            this.collection.push(new Model());
        },
        remove: function(e) {
            var target = e.currentTarget;
            var index  = target.getAttribute('data-id');

            var at = this.collection.at(index);
            this.collection.remove(at);

            this.render();
        },
        render: function() {
            console.log('view:this', this);
            console.log('view:collection', this.collection);

            var output = this.template({
                results:this.collection.toJSON()
            });

            $(output).find('.actions .delete').on('click', this.remove);

            var wrap = this.$el.find('.wrap');
            wrap.empty();
            wrap.html(output);

            return this;
        }
    });

    var Database = new Accordion(<?php echo json_encode($vars['accordion']); ?>);

    var view = new View({collection:Database});
    view.render();
}(window.jQuery);
</script>