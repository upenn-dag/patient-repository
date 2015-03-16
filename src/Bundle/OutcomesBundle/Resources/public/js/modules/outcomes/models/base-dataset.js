// modules/outcomes/models/base-dataset.js
define(function(require, exports, module) {
    "use strict";

    var Backbone = require("backbone");
    var BaseDataset = Backbone.Model.extend({
    	initialize: function(options) {
    		console.log(options);
    	}
    });

    return BaseDataset;
});
