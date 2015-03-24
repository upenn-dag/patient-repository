// modules/outcomes/views/translations.js
define(function(require, exports, module) {
    "use strict";

    require("backbone");
    var TranslationsView = Backbone.View.extend({
        el: document.getElementById('translations-container'),
        template: _.template(require("text!modules/outcomes/templates/translations.html")),

        initialize: function() {
            this.render();
        },

        render: function() {
            this.$el.html(this.template({}));

            return this;
        }
    });

    return TranslationsView;
});