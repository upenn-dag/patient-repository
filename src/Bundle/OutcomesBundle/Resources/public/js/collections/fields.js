// collections/fields.js

define([
    'underscore',
    'backbone',
    'models/field'
], function(_, Backbone, Field) {
    'use strict';

    var FieldCollection = Backbone.Collection.extend({
        model: Field,

        primary: function() {
            var idFields = this.where({ primary: true });

            return idFields.length > 1 ? idFields : idFields[0];
        },

        // Get required fields.
        required: function() {
            return this.where({ nullable: false });
        },

        // Get common (static) fields.
        common: function() {
            return this.where({ dynamic: false });
        },

        // Get dynamic fields.
        dynamic: function() {
            return this.where({ dynamic: true });
        },

        // Fields are sorted by name.
        comparator: 'name'
    });

    return FieldCollection;
});
