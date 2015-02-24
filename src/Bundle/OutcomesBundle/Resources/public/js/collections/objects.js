// collections/object.js
define([
    'underscore',
    'backbone',
    'models/object'
], function(_, Backbone, ObjectModel) {
    'use strict';

    var ObjectCollection = Backbone.Collection.extend({
        model: ObjectModel,
        comparator: 'name'
    });

    return new ObjectCollection();
});
