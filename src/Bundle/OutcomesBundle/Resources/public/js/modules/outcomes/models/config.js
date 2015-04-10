// modules/outcomes/models/config.js
define(function(require, exports, module) {
    "use strict";

    var Backbone = require("backbone");
    var Filters = require("modules/outcomes/collections/filters");
    var Translations = require("modules/outcomes/collections/translations");

    var Config = Backbone.Model.extend({
        defaults: {
            object: null,
            objectPrototype: null,
            translations: null,
            exportFormat: "csv"
        },

        allowedExportFormats: ["csv", "xml", "json"],

        initialize: function() {
            this.set("translations", new Translations());
        },

        getExportFormat: function() {
            return this.get("exportFormat");
        },

        setExportFormat: function(format) {
            if (-1 === this.allowedExportFormats.indexOf(format)) {
                throw format + " is not a valid export format.";
            }

            this.set("exportFormat", format);
        },

        serialize: function() {
            return this.getConfig();
        },

        getConfig: function() {
            var config = { target: this.getObject().get("name") };
            var fields = this.getObject().getFields();
            var translations = this.getTranslations();

            // This should accomodate multiple filters at some point.

            config["target-prototype"] = this.hasObjectPrototype() ? this.getObjectPrototype().get("name") : null;
            config["fields"] = {};
            config["translations"] = {};

            fields.each(function(field) {
                var fieldName = field.get("name");
                var filters = field.get("filters");
                if (filters && filters.length) {
                    config.fields[fieldName] = { filters: [] };
                    filters.each(function(filter) {
                        config.fields[fieldName].filters.push({
                            name: filter.get("type"),
                            options: filter.get("options") || []
                        });
                    });
                }
            });

            translations.each(function(translation) {
                config.translations[translation.get("key")] = translation.get("definition");
            });
            
            return config;
        },

        // TARGETING METHODS

        setObject: function(object) {
            if (this.get("object")) {
                this.get("object").deactivate();
            }

            object.activate();
            this.set("object", object);
        },

        getObject: function() {
            return this.get("object");
        },

        hasObject: function() {
            return !!this.get("object");
        },

        setObjectPrototype: function(prototype) {
            this.set("objectPrototype", prototype);
        },

        getObjectPrototype: function() {
            return this.get("objectPrototype");
        },

        hasObjectPrototype: function() {
            return !!this.get("objectPrototype");
        },


        // FILTERING METHODS

        getFilters: function() {
            return this.get("filters");
        },


        // TRANSFORMING METHODS

        translatable: function() {
            return this.filterable();
        },

        getTranslations: function() {
            return this.get("translations");
        },

        addTranslation: function(translation) {
            this.getTranslations().add(translation);
        },

        removeTranslation: function(translation) {
            this.getTranslations().remove(translation);
        },

        hasTranslation: function(translation) {
            return -1 < this.getTranslations().indexOf(translation);
        },

        
        // EXPORT METHODS

        exportable: function() {
            return this.get("translated");
        }
    });

    return Config;
});
