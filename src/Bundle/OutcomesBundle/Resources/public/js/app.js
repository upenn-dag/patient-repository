// app.js
define(function(require, exports, module) {
    "use strict";

    var root = "/app_dev.php/outcomes/";

    exports.root             = root;
    exports.stateUri         = root + "state.json";
    exports.filtersUri       = root + "filters.json";
    exports.filteredUri      = root + "filtered.json";
    exports.translatedUri    = root + "translated.json";
    exports.availableFilters = [];
    exports.filterData       = null;


    // Some extensions, this may not belong here...
    exports.filterExists = function(filter) {
        var found = false;
        this.availableFilters.forEach(function(aFilter) {
            if (aFilter == filter) {
                found = true;
            }
        });

        return found;
    };

    exports.filterTypes = function(filter) {
        if (!this.filterExists(filter)) throw 'Filter "'+filter+'" could not be found.';

        return this.filterData.filters[filter].types;
    };

    exports.getFilter = function(filter) {
        if (!this.filterExists(filter)) throw 'Filter "'+filter+'" could not be found.';

        return this.filterData.filters[filter];
    };

    exports.filterAllowsType = function(filter, type) {
        var found = false;
        var filterTypes = this.filterTypes(filter);
        filterTypes.forEach(function(fType) {
            if (fType == type) {
                found = true;
            }
        });

        return found;
    }

    exports.allowedFilters = function(fieldType) {
        var allowed = [];
        var self = this;
        this.availableFilters.forEach(function(aFilter) {
            if (self.filterAllowsType(aFilter, fieldType)) {
                allowed.push(aFilter);
            }
        });

        return allowed;
    };
});
