function Accordion(config)
{
    if(typeof config != "object" || !config.id) {
        throw new Error('Config is not object');
    }
    
    var that = this;

    that.config = jQuery.extend({
        'data':[],
    }, config);

    that.element = jQuery('#'+ config.id);
    if(!that.element) {
        return;
    }
    
    var Items = Backbone.Model.extend({
        defaults: {
            keyword : '',
            label   : '',
            content : '',
        },
    });
    
    var Collection = Backbone.Collection.extend({
        model: Items
    });
    
    var View = Backbone.View.extend({
        el: that.element,
        template: _.template(that.element.find('[type="text/template"]').html()),
        
        events : {
            'click  input[type="button"].create':'create',
            'click  input[type="button"].delete':'remove',
            'change [data-id]':'changed'
        },
        
        initialize: function() {
            console.log('widget accordion:initialized', this);

            _.bindAll(this, 'changed');

            this.collection.on('add',    this.render, this);
            this.collection.on('remove', this.render, this);
        },
        changed: function(e) {
            var target = jQuery(e.target);
            var index  = target.parents('[data-index]:first').attr('data-index');
            var at     = this.collection.at(index);
            at.set(target.attr('data-id'), target.val());
        },
        create: function() {
            console.log('widget accordion:action.create', this);

            this.collection.push(new Items());
        },
        remove: function(e) {
            console.log('widget accordion:action.remove', this);

            var target = e.currentTarget;
            var index  = target.getAttribute('data-id');

            var at = this.collection.at(index);
            this.collection.remove(at);
        },
        render: function() {
            console.log('widget accordion:action:render', this);

            var output = this.template({
                results : this.collection.toJSON()
            });

            var wrap = this.$el.find('.wrap');
            wrap.empty().html(output);
        }
    });

    var database = that.config.data;
    return new View({
        collection: new Collection(database)
    }).render();
};