// app.js
define(function(require, exports, module) {
    "use strict";

    var root = "/app_dev.php/outcomes/";

    exports.root        = root;
    exports.stateUri    = root + "state.json";
    exports.filtersUri  = root + "filters.json";
    exports.filteredUri = root + "filtered.json";

    exports.availableFilters = [];
    exports.filterData       = null;
});
