// modules/outcomes/views/export.js
define(function(require, exports, module) {
    "use strict";

    require("backbone");
    var ExportView = Backbone.View.extend({
        el: document.getElementById('export-container'),
        template: _.template(require("text!modules/outcomes/templates/export.html")),

        initialize: function() {
            this.render();
        },

        render: function() {
            this.$el.html(this.template({}));

            return this;
        }
    });

    return ExportView;
});