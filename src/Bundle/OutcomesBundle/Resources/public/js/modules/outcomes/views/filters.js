// modules/outcomes/views/filters.js
define(function(require, exports, module) {
    "use strict";

    require("jquery.serialize");
    require("backbone");
    require("bootstrap.table");

    var app = require("app");
    var Utils = require("modules/outcomes/utils");
    var FieldView = require("modules/outcomes/views/field");

    var FiltersView = Backbone.View.extend({
        el: document.getElementById('filters-container'),
        template: _.template(require("text!modules/outcomes/templates/filters.html")),
        rendered: false,
        dataset: null,
        datasetModal: null,
        datasetTable: null,
        datasetCount: null,
        configuration: null,
        configModal: null,
        configSave: null,

        events: {
            "click #preview-base-dataset": "_handleDatasetPreview",
            "click #configuration-save": "_handleConfigSave",
        },

        initialize: function() {
            this.fields = app.model.getObject().getFields();

            this.listenTo(this.fields, "configure", this._handleConfig);
        },

        _handleDatasetPreview: function() {
            event.preventDefault();
            this.preview();
            return false;
        },

        _handleConfig: function(field, filter, configView) {
            event.preventDefault();
            this.configure(field, filter, configView);
            return false;
        },

        _handleConfigSave: function() {
            event.preventDefault();
            var data = this.$el.find("#filter-config-form").serializeJSON();
            this.save(data);
            this.configModal.modal("hide");
            return false;
        },

        loadDataset: function() {
            var self = this;
            var config = app.model.getConfig();
            var jqxhr = $.ajax({
                type: "POST",
                dataType: "json",
                url: app.filteredUri,
                data: JSON.stringify(config),
            });

            jqxhr.done(function(response) {
                var t = response.data;

                if (0 === Utils.objectSize(t)) {
                    self.dataset.html("No results were returned.");
                    return;
                }

                var columns = Object.keys(t[0]);
                var table = document.createElement("table");
                var thead = document.createElement("thead");
                var thRow = document.createElement("tr");

                for (var i = 0; i < columns.length; i++) {
                    var th = document.createElement("th");
                    th.setAttribute("data-field", columns[i]);
                    th.setAttribute("data-title", _.humanize(columns[i]));
                    th.setAttribute("data-sortable", "true");
                    th.appendChild(document.createTextNode(columns[i]));
                    thRow.appendChild(th);
                };

                thead.appendChild(thRow);
                table.appendChild(thead);

                var $table = $(table).bootstrapTable({
                    data: t,
                    striped: true,
                    classes: "table table-hover table-condensed",
                });

                self.datasetCount.html(response.count);

                self.bootstrapTable = $table;
                self.dataset.html($table);
            });
        },

        save: function(data) {
            this.activeFilter.set({
                type: data.type,
                options: data.options,
                name: _.humanize(data.type),
                state: this.activeFilter.getActiveState(),
            });

            // TODO: We should validate that all required fields are filled out...

            this.activeField = null;
            this.activeFilter = null;
        },

        preview: function() {
            this.dataset.html("Loading dataset.");
            this.loadDataset();
            this.datasetModal.modal("show");
        },

        configure: function(field, filter, configView) {
            this.configuration.html(configView.$el);
            this.activeField = field;
            this.activeFilter = filter;
            this.configModal.modal("show");
        },

        render: function() {
            var fields = this.fields;

            this.$el.html(this.template({ target: app.model.getObject().toJSON(), fields: fields.toJSON() }));

            // Hide header button by default.
            this.$el.find(".section-next").hide();

            // Render active fields...
            var $elFields = this.$el.find("#fields");
            fields.each(function(field) {
                field.filterView = this;
                var fieldView = new FieldView({ model: field }).render();
                $elFields.append(fieldView.$el);
            });

            this.dataset = this.$el.find("#base-dataset");
            this.datasetModal = this.$el.find("#base-dataset-modal");
            this.datasetCount = this.$el.find("#base-dataset-count");
            this.configuration = this.$el.find("#configuration");
            this.configModal = this.$el.find("#configuration-modal");
            this.configSave = this.$el.find("#configuration-save");

            // Make sure we clear the modals when they are hidden.
            this.datasetModal.data("dataset", this.dataset);
            this.configModal.data("configuration", this.configuration);

            this.datasetModal.on("hidden.bs.modal", function(event) {
                $(this).data("dataset").children().detach();
            });

            this.configModal.on("hidden.bs.modal", function(event) {
                $(this).data("configuration").children().detach();
            });

            this.rendered = true;

            return this;
        }
    });

    return FiltersView;
});