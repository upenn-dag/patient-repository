// modules/outcomes/views/config.js
define(function(require, exports, module) {
    "use strict";

    require("backbone");
    var app = require("app");
    var FilterModel = require("modules/outcomes/models/filter");

    var ConfigView = Backbone.View.extend({
        model: FilterModel,
        template: _.template(require("text!modules/outcomes/templates/config.html")),
        optionTemplate: _.template(require("text!modules/outcomes/templates/option.html")),
        options: null,

        events: {
            "change #filter-config-name": "_handleFilterSwitch",
        },

        _handleFilterSwitch: function() {
            var $type = $(event.target);
            var filter = app.getFilter($type.val());

            this.options.html("");

            for (var option in filter.options) {
                if (!filter.options.hasOwnProperty(option)) continue;
                var optionObj = _.extend(filter.options[option], { name: option });
                var optionHtml = this.optionTemplate(filter.options[option]);
                this.options.append(optionHtml);
            }
        },

        render: function() {
            var field = this.model.get("field");
            var fieldType = field.get("type")
            var allowedFilters = app.allowedFilters(fieldType);

            this.$el.html(this.template({
                filter: this.model.toJSON(),
                filters: allowedFilters,
                field: field.toJSON(),
            }));

            this.options = this.$el.find("#filter-config-options");

            // TODO: Render the options for selected one?

            return this;
        }
    });

    return ConfigView;
});