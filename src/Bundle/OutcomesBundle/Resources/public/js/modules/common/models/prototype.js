// modules/common/models/prototype.js
define(function(require, exports, module) {
    "use strict";

    var Backbone = require("backbone");
    var Prototype = Backbone.Model.extend({
        idAttribute: "name",
    });

    return Prototype;
});
