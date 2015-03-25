// modules/outcomes/models/filter.js
define(function(require, exports, module) {
    "use strict";

    // Various filter states, used in presentation and config creation.
    var FILTER_INACTIVE = "inactive";
    var FILTER_ACTIVE = "active";
    var FILTER_DISABLED = "disabled";

    var Backbone = require("backbone");
    var Filter = Backbone.Model.extend({
        sync: function() { return false; },
        defaults: {
            name: "New Filter",
            type: null,
            state: FILTER_INACTIVE,
        },

        getInactiveState: function() {
            return FILTER_INACTIVE;
        },

        getActiveState: function() {
            return FILTER_ACTIVE;
        },

        getDisabledState: function() {
            return FILTER_DISABLED;
        },

        active: function() {
            return FILTER_ACTIVE === this.get("state");
        },

        inactive: function() {
            return FILTER_INACTIVE === this.get("state");
        },

        enabled: function() {
            return FILTER_DISABLED !== this.get("state");
        },

        disabled: function() {
            return FILTER_DISABLED === this.get("state");
        },

        activate: function() {
            this.set("state", FILTER_ACTIVE);
        },

        deactivate: function() {
            this.set("state", FILTER_INACTIVE);
        },

        disable: function() {
            this.set("state", FILTER_DISABLED);
        }
    });

    return Filter;
});
