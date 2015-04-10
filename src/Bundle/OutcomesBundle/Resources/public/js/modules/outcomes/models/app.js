// modules/outcomes/models/app.js
define(function(require, exports, module) {
    "use strict";

    var Backbone = require("backbone");
    var Filters = require("modules/outcomes/collections/filters");
    var Translations = require("modules/outcomes/collections/translations");
    var App = Backbone.Model.extend({
        defaults: {
            object: null,
            objectPrototype: null,
            filtered: false,
            filters: null,
            translated: false,
            translations: null,
        },

        initialize: function() {
            this.set("filters", new Filters());
            this.set("translations", new Translations());
        },

        getConfig: function() {
            var config = { target: this.getObject().get("name") };
            var fields = this.getObject().getFields();
            var translations = this.getTranslations();

            // This should accomodate multiple filters at some point.

            config["target-prototype"] = this.hasObjectPrototype() ? this.getObjectPrototype().get("name") : null;
            config["filters"] = {};
            config["translations"] = {};

            fields.each(function(field) {
                var fieldName = field.get("name");
                var filter = field.get("filter");
                if (filter) {
                    config.filters[fieldName] = {
                        name: filter.get("type"),
                        options: filter.get("options") || [],
                    }
                }
            });

            translations.each(function(translation) {
                config.translations[translation.get("key")] = translation.get("definition");
            });

            console.log("Configuration generated: ", config);
            
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

        filterable: function() {
            return !!this.get("object");
        },

        getFilters: function() {
            return this.get("filters");
        },

        addFilter: function(filter) {
            this.getFilters().add(filter);
        },

        removeFilter: function(filter) {
            this.getFilters().remove(filter);
        },

        hasFilter: function(filter) {
            return -1 < this.getFilters().indexOf(filter);
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

    return App;
});
