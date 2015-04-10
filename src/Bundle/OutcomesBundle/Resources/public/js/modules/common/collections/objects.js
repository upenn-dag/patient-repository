// modules/common/collections/object.js
define(function(require, exports, module) {
    "use strict";

    var Backbone = require("backbone");
    var ObjectCollection = Backbone.Collection.extend({
        model: require("modules/common/models/object"),

        active: function() {
            return this.where({ active: true });
        },

        inactive: function() {
            return this.where({ active: false });
        }
    });

    return ObjectCollection;
});
