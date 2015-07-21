// main.js
require.config({
    waitSeconds: 2,
    shim: {
        "jquery": { exports: "$" },
        "jquery.serialize": { deps: ["jquery"] },

        "underscore.inflection": { deps: ["underscore", "underscore.string"] },

        "backbone": { deps: ["jquery", "underscore.mixed"], exports: "Backbone" },
        "marionette": { deps: ["backbone"], exports: "Marionette" },
        "backbone.notifier": { deps: ["jquery", "backbone", "underscore"], exports: "Backbone.notifier" },
        "backbone.grid": { deps: ["jquery", "bootstrap", "backbone", "underscore"], exports: "Backbone.grid" },
        "backbone.localstorage": { deps: ["backbone"], exports: "Store" },

        "bootstrap": { deps: ["jquery"], exports: "Bootstrap" },
        "bootstrap.table": { deps: ["bootstrap"], exports: "BootstrapTable" },
    },
    paths: {
        "debug": "libs/debug",

        "jquery": "libs/jquery",
        "jquery.serialize": "libs/jquery.serialize",

        "underscore": "libs/underscore",
        "underscore.inflection": "libs/underscore.inflection",
        "underscore.string": "libs/underscore.string",
        "underscore.mixed": "libs/underscore.mixed",

        "backbone": "libs/backbone",
        "marionette": "libs/backbone.marionette",
        "backbone.notifier": "libs/backbone.notifier",
        "backbone.localstorage": "libs/backboneLocalstorage",

        "bootstrap": "libs/bootstrap",
        "bootstrap.table": "libs/bootstrap-table",

        domReady: "libs/domReady",
        text: "libs/text",
        json: "libs/json",
    }
});

define(function(require, exports, module) {
    "use strict";

    // Require globally available modules.
    require("debug");

    return {
        initialize: function(options) {
            var State = require("modules/common/models/state");
            var outcomes = require("modules/outcomes/application");
            var options = options || {};

            // Initialize sub apps?
            require("modules/outcomes/apps/targets/app");

            // Preload state data.
            var stateDf = $.ajax({
                url: options.stateUrl
            })
            .done(function(response) {
                options.state = new State(response);
            });

            // Preload filter data.
            var filtersDf = $.ajax({
                url: options.filterUrl
            })
            .done(function(response) {
                options.filters = response;
            });

            // Perform preload, when promises are fufilled start outcomes.
            $.when(
                stateDf,
                filtersDf
            )
            .done(function() {
                outcomes.start(options)
            })
            .fail(function() {
                debug.error("Application failed to start due to pre-load failures.", { options: options });
            });
        }
    }
});
