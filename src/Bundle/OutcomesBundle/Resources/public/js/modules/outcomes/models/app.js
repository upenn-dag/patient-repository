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

            // This should accomodate multiple filters at some point.

            config["target-prototype"] = this.hasObjectPrototype() ? this.getObjectPrototype().get("name") : null;
            config["filters"] = {};

            fields.each(function(field) {
                var fieldName = field.get("name");
                var filter = field.get("filter");
                if (filter) {
                    config["filters"][fieldName] = {
                        name: filter.get("type"),
                        options: filter.get("options") || [],
                    }
                }
            });

            config["translations"] = {};
            // this.getTranslations().each(function(translation) {
            //     console.log('Add translation to config');
            // });

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

        addTranslation: function(translation) {
            this.translations.add(translation);
        },

        hasTranslation: function(translation) {
            return -1 < this.translations.indexOf(translation);
        },

        translatable: function() {
            return this.filterable();
        },

        exportable: function() {
            return this.get("translated");
        }
    });

    return App;
});
