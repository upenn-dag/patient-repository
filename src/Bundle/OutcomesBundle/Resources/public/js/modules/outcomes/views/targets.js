// modules/outcomes/views/targets.js
define(function(require, exports, module) {
    "use strict";

    require("backbone");

    var TargetView = require("modules/outcomes/views/target");
    var TargetsView = Backbone.View.extend({
        el: document.getElementById('targets-container'),
        collection: require("modules/common/collections/objects"),
        template: _.template(require("text!modules/outcomes/templates/targets.html")),

        initialize: function() {
            this.listenTo(this.collection, "change:active", this.showNext);
            this.render();
        },

        showNext: function(target, active) {
            this.$el.find(".section-next").show();
        },

        render: function() {
            this.$el.html(this.template({}));

            // Hide header button by default.
            this.$el.find(".section-next").hide();

            var $el = this.$el.find('#targets');
            this.collection.each(function(target) {
                var target = new TargetView({ model: target });
                $el.append(target.$el);
            });

            return this;
        }
    });

    return TargetsView;
});