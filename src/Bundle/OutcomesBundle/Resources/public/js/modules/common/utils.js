// modules/common/util.js
define(function(require, exports, module) {
    "use strict";

    require("backbone.notifier");

    return {
        notifier: new Backbone.Notifier({})
    };
});
