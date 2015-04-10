// modules/common/collections/prototype.js
define(function(require, exports, module) {
    "use strict";

    var Backbone = require("backbone");
    var PrototypeCollection = Backbone.Collection.extend({
        model: require("modules/common/models/prototype"),
        comparator: "name",

        getFields: function() {
            return this.get("fields");
        },
        getField: function(name) {
            return this.getFields().get(name);
        }
    });

    return PrototypeCollection;
});
