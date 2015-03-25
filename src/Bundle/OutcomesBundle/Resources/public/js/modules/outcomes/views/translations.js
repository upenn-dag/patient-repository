// modules/outcomes/views/translations.js
define(function(require, exports, module) {
    "use strict";

    require("jquery.serialize");
    require("backbone");
    require("bootstrap.table");

    var app = require("app");
    var Utils = require("modules/outcomes/utils");
    var TranslationsCollection = require("modules/outcomes/collections/translations");
    var TranslationView = require("modules/outcomes/views/translation");
    var TranslationModel = require("modules/outcomes/models/translation");

    var TranslationsView = Backbone.View.extend({
        el: document.getElementById('translations-container'),
        collection: TranslationsCollection,
        template: _.template(require("text!modules/outcomes/templates/translations.html")),
        translations: null,
        dataset: null,
        datasetModal: null,

        events: {
            "click #add-translation": "_handleAddTranslation",
            "click .translation-remove": "_handleRemoveTranslation",
            "click #preview-translated-dataset": "_handlePreview",
        },

        initialize: function() {
            this.listenTo(this.collection, "add", this.addTranslation);
            this.listenTo(this.collection, "remove", this.removeTranslation);
        },

        _handleAddTranslation: function() {
            event.preventDefault();
            this.collection.add(new TranslationModel());
            return false;
        },

        _handleRemoveTranslation: function() {
            event.preventDefault();
            var $translation = $(event.target).parents(".translation").first();
            var translation = $translation.data("translation");
            this.collection.remove(translation);
            return false;
        },

        _handlePreview: function() {
            if (0 === this.collection.length) {
                alert("You must first define at least one translation.");
                return;
            }

            this.preview();
        },

        addTranslation: function(translation) {
            var translationView = new TranslationView({ model: translation }).render();
            this.translations.append(translationView.$el);
            translationView.$el.find(".translation-key").focus();
        },

        removeTranslation: function(translation) {
            translation.get("view").remove();
        },

        loadDataset: function() {
            var self = this;
            var config = app.model.getConfig();
            var jqxhr = $.ajax({
                type: "POST",
                dataType: "json",
                url: app.translatedUri,
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

        preview: function() {
            this.dataset.html("Loading dataset.");
            this.loadDataset();
            this.datasetModal.modal("show");
        },

        render: function() {
            this.$el.html(this.template({}));
            this.translations = this.$el.find("#translations");
            this.dataset = this.$el.find("#translated-dataset");
            this.datasetModal = this.$el.find("#translated-dataset-modal");
            this.datasetCount = this.$el.find("#translated-dataset-count");

            // Make sure we clear the modals when they are hidden.
            this.datasetModal
                .data("dataset", this.dataset)
                .on("hidden.bs.modal", function(event) {
                    $(this).data("dataset").children().detach();
                });

            var self = this;

            this.collection.each(function(translation) {
                self.addTranslation(translation);
            });

            return this;
        }
    });

    return TranslationsView;
});