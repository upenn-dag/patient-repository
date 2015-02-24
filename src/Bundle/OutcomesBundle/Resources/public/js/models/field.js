// models/field.js

define([
    'underscore',
    'backbone'
], function(_, Backbone) {
    'use strict';

    var Field = Backbone.Model.extend({

        idAttribute: "name",

        isDynamic: function() {
            return this.get('dynamic');
        },

        isPrimary: function() {
            return this.get('primary');
        },

        isUnique: function() {
            return this.get('unique');
        }

    });

    return Field;
});