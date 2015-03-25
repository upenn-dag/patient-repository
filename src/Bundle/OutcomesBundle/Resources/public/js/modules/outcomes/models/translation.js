// modules/outcomes/models/translation.js
define(function(require, exports, module) {
    "use strict";

    var Backbone = require("backbone");
    var Translation = Backbone.Model.extend({
    	sync: function() { return false; }
    });

    return Translation;
});
