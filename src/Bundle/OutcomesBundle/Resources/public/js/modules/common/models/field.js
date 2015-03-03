// modules/common/models/field.js
define(function(require, exports, module) {
    "use strict";

    var Backbone = require("backbone");
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
