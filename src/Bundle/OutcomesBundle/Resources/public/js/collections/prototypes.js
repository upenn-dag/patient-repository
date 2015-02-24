// collections/prototype.js

define([
    'underscore',
    'backbone',
    'models/prototype'
], function(_, Backbone, Prototype) {
    'use strict';

    var PrototypeCollection = Backbone.Collection.extend({
        model: Prototype,

        getFields: function() {
        	return this.get('fields');
        },

        getField: function(name) {
        	return this.getFields().get(name);
        },

        comparator: 'name'
    });

    return PrototypeCollection;
});
