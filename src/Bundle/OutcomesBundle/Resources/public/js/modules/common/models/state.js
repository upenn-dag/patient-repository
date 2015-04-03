// modules/common/models/state.js
define(function(require, exports, module) {
    "use strict";

    var Objects = require("modules/common/collections/objects");
    var State = Backbone.Model.extend({
        initialize: function(options) {
            var objKeys = Object.keys(options.objects);
            var objects = new Objects();

            for (var i = 0; i < objKeys.length; i++) {
                objects.add(options.objects[objKeys[i]]);
            }

            this.set("objects", objects);
        },
        getObjects: function() {
            return this.get("objects");
        },
        getObject: function(name) {
            return this.getObjects().get(name);
        }
    });

    return State;
});