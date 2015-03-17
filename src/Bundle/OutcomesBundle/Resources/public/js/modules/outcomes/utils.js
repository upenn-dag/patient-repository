// modules/outcomes/util.js
define(function(require, exports, module) {
    "use strict";

    var BaseUtil = require("modules/common/utils");

    BaseUtil.notifier.navigationWarning = function(message) {
        return this.notify({
            type: "warning",
            ms: 3000,
            destroy: false,
            title: "Navigation error!",
            message: message,
        });
    };

    BaseUtil.dataTranslate = function(data) {
        console.log(data);
    };

    return BaseUtil;
});
