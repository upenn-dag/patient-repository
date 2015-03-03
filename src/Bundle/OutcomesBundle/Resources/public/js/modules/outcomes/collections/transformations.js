// modules/outcomes/collections/transformations.js
define(function(require, exports, module) {
    "use strict";

    var Backbone = require("backbone");
    var Transformations = Backbone.Collection.extend({
        model: require("modules/outcomes/models/transformation")
    });

    return Transformations;
});
