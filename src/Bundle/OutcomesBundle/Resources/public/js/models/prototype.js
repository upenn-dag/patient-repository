// models/prototype.js

define([
    'underscore',
    'backbone'
], function(_, Backbone) {
    'use strict';

    var Prototype = Backbone.Model.extend({

        idAttribute: "name",
        
    });

    return Prototype;
});