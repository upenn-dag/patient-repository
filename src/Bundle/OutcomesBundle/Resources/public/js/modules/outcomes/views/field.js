// modules/outcomes/views/field.js
define(function(require, exports, module) {
    "use strict";

    require("backbone");
    var FilterModel = require("modules/outcomes/models/filter");
    var FilterView = require("modules/outcomes/views/filter");

    var FieldView = Backbone.View.extend({
        model: require("modules/common/models/field"),
        template: _.template(require("text!modules/outcomes/templates/field.html")),
        filterList: null,

        events: {
            "click .field-remove": "remove",
            "click .field-filter-add": "addFilter",
            "click .field-filter-remove": "removeFilter",
        },

        initialize: function() {
            this.listenTo(this.model, "change:filter", this._handleFilterChange);
        },

        _handleFilterChange: function(model, filter) {
            this.renderFilter();
        },

        remove: function() {
            this.removeFilter();
            this.$el.detach();
        },

        addFilter: function() {
            if (!!this.model.get("filter")) {
                alert("We currently only allow on filter per field");
                return;
            }

            var model = new FilterModel();
            model.set("field", this.model);
            this.model.set("filter", model);
        },

        removeFilter: function() {
            this.model.set("filter", null);
        },

        renderFilter: function() {
            this.filterList.html("");
            var filter = this.model.get("filter");
            if (filter) {
                var filterView = new FilterView({ model: filter }).render();
                filterView.fieldView = this;
                this.filterList.append(filterView.$el);
            }
        },

        render: function() {
            this.$el.html(this.template(this.model.toJSON()));
            this.filterList = this.$el.find(".field-filters");

            return this;
        }
    });

    return FieldView;
});