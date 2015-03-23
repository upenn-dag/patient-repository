// modules/outcomes/views/filters.js
define(function(require, exports, module) {
    "use strict";

    require("backbone");
    var app = require("app");
    var Utils = require("modules/outcomes/utils");
    var FilterModel = require("modules/outcomes/models/filter");
    var ConfigView = require("modules/outcomes/views/config");

    var FilterView = Backbone.View.extend({
        tagName: "li",
        className: "list-group-item",
        model: FilterModel,
        template: _.template(require("text!modules/outcomes/templates/filter.html")),
        configView: null,

        events: {
            "click .field-filter-configure" : "configure",
        },

        initialize: function() {
            this.listenTo(this.model, "change", this.render);
        },

        configure: function() {
            var field = this.model.get("field");
            var fieldType = field.get("type")
            var allowedFilters = app.allowedFilters(fieldType);

            // If no filters work here, throw an error.
            if (0 == allowedFilters.length) {
                Utils.notifier.navigationWarning('There are no filters capable of handling "'+fieldType+'" fields.');
                this.model.disable();
                return;
            }

            // Create the config view for this action.
            this.configView = this.configView || new ConfigView({ model: this.model }).render();

            // Run configuration at the field level, now that we're setup.
            field.trigger("configure", field, this.model, this.configView);
        },

        render: function() {
            this.$el.html(this.template(this.model.toJSON()));
            this.$el.addClass("state-"+this.model.get("state"));
            return this;
        }
    });

    return FilterView;
});