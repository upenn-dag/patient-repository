// modules/outcomes/outcomes.js
define(function(require, exports, module) {

    // UTILITIES
    var app = require("app");

    // LOAD ALL FILTERS
    $.ajax({
        type: "GET",
        url: app.filtersUri,
        dataType: "json",
        complete: function(response) {
            app.filterData = response.responseJSON;
            app.availableFilters = Object.keys(app.filterData.filters);
        },
        fail: function() {
            // Handle this better, with app locking?!
            alert("Unable to load filters.");
        }
    });

    exports.Router = require("modules/outcomes/router");
});
