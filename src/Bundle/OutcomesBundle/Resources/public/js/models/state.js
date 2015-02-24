// models/state.js

define([
    'underscore',
    'backbone',
    'collections/objects',
], function(_, Backbone, Objects) {
    'use strict';

    var State = Backbone.Model.extend({
        initialize: function(options) {
            var objKeys = Object.keys(options.objects);

            for (var i = 0; i < objKeys.length; i++) {
                Objects.add(options.objects[objKeys[i]]);
            }

            this.set('objects', Objects);
        },

        // Return an object by name
        getObject: function(name) {
            return this.get('objects').get(name);
        }
    });

    return State;
});