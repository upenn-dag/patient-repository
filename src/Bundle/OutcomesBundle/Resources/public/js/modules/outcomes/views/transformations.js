// modules/outcomes/views/transformations.js
define(function(require, exports, module) {
    "use strict";

    require("backbone");
    var TransformationsView = Backbone.View.extend({
        el: document.getElementById('transformations-container'),
        template: _.template(require("text!modules/outcomes/templates/transformations.html")),

        initialize: function() {
            this.render();
        },

        render: function() {
            this.$el.html(this.template({}));

            return this;
        }
    });

    return TransformationsView;
});