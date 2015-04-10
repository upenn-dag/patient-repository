// modules/outcomes/collections/filters.js
define(function(require, exports, module) {
    "use strict";

    var Backbone = require("backbone");
    var Filters = Backbone.Collection.extend({
        model: require("modules/outcomes/models/filter")
    });

    return Filters;
});
