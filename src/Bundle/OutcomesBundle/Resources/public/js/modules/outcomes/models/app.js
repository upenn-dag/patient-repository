// modules/outcomes/models/app.js
define(function(require, exports, module) {
    "use strict";

    var Backbone = require("backbone");
    var Filters = require("modules/outcomes/collections/filters");
    var Transformations = require("modules/outcomes/collections/transformations");
    var App = Backbone.Model.extend({
        defaults: {
            object: null,
            objectPrototype: null,
            filtered: false,
            filters: null,
            transformed: false,
            transformations: null,
        },

        initialize: function() {
            this.set("filters", new Filters());
            this.set("transformations", new Transformations());
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

        hasFilter: function(filter) {
            return -1 < this.getFilters().indexOf(filter);
        },


        // TRANSFORMING METHODS

        addTransformation: function(transformation) {
            this.transformations.add(transformation);
        },

        hasTransformation: function(transformation) {
            return -1 < this.transformations.indexOf(transformation);
        },

        transformable: function() {
            return this.get("filtered");
        },

        exportable: function() {
            return this.get("transformed");
        }
    });

    return App;
});
