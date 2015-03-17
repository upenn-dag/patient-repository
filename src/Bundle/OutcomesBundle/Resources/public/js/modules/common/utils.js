// modules/common/util.js
define(function(require, exports, module) {
    "use strict";

    require("backbone.notifier");

    return {
        notifier: new Backbone.Notifier({}),
        objectSize: function(obj) {
        	var size = 0, key;
        	for (key in obj) {
        		if (obj.hasOwnProperty(key)) size++;
        	}
        	return size;
        }
    };
});
