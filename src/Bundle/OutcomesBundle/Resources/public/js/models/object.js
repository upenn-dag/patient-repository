// models/object.js

define([
    'underscore',
    'backbone',
    'collections/prototypes',
    'collections/fields',
    'models/field'
], function(_, Backbone, Prototypes, Fields, Field) {
    'use strict';

    var ObjectModel = Backbone.Model.extend({

        idAttribute: "name",
        
        initialize: function(options) {
            var prototypes = new Prototypes();
            var fields = new Fields();
            var prototype;

            if (options.fields) {
                var fKeys = Object.keys(options.fields);
                for (var i = 0; i < fKeys.length; i++) {
                    fields.add(options.fields[fKeys[i]]);
                }
            }

            if (options.prototypes) {
                var pKeys = Object.keys(options.prototypes);
                for (var i = 0; i < pKeys.length; i++) {
                    prototype = new Field(options.prototypes[pKeys[i]]);
                    prototype.set('fields', fields);
                    prototypes.add(prototype);
                }
            }

            this.set('prototypes', prototypes);
            this.set('fields', fields);
        },

        // Return prototype collection.
        getPrototypes: function() {
            return this.get('prototypes');
        },

        // Return a prototype by name.
        getPrototype: function(name) {
            return this.getPrototypes().get(name);
        },

        // Return field collection.
        getFields: function() {
            return this.get('fields');
        },

        // Return a field by name.
        getField: function(name) {
            return this.getFields().get(name);
        }
    });

    return ObjectModel;
});