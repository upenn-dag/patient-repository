// view/test/test.js
define([
    'jquery',
    'underscore',
    'backbone',
    'util',
    'text!templates/debug.html'
], function($, _, Backbone, Util, debugTemplate) {
    var DebugView = Backbone.View.extend({
        template: _.template(debugTemplate),
        initialize: function() {
            Util.debug.setView(this);
        },
        render: function() {
            var data = {
                jqueryVersion: $.fn.jquery,
                backboneVersion: Backbone.VERSION,
                underscoreVersion: _.VERSION
            };

            this.$el.html(this.template(data));

            return this;
        },

        show: function() {
            Util.debug.show();
        },

        hide: function() {
            Util.debug.hide();
        },

        toggle: function() {
            Util.debug.toggle();
        }
    });

    return DebugView;
});
