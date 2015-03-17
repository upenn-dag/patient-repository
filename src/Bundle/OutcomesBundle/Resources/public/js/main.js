// main.js
require.config({
    waitSeconds: 2,
    baseUrl: "/bundles/accardoutcomes/js",
    shim: {
        jquery: { exports: "$" },

        "underscore.inflection": { deps: ["underscore", "underscore.string"] },

        "backbone": { deps: ["jquery", "underscore.mixed"], exports: "Backbone" },
        "backbone.notifier": { deps: ["jquery", "backbone", "underscore"], exports: "Backbone.notifier" },
        "backbone.grid": { deps: ["jquery", "bootstrap", "backbone", "underscore"], exports: "Backbone.grid" },
        "backbone.localstorage": { deps: ["backbone"], exports: "Store" },

        "bootstrap": { deps: ["jquery"], exports: "Bootstrap" },
        "bootstrap.table": { deps: ["bootstrap"], exports: "BootstrapTable" },
    },
    paths: {
        "underscore": "libs/underscore",
        "underscore.inflection": "libs/underscore.inflection",
        "underscore.string": "libs/underscore.string",
        "underscore.mixed": "libs/underscore.mixed",

        "backbone": "libs/backbone",
        "backbone.notifier": "libs/backbone.notifier",
        "backbone.localstorage": "libs/backboneLocalstorage",

        "bootstrap": "libs/bootstrap",
        "bootstrap.table": "libs/bootstrap-table",

        jquery: "libs/jquery",
        domReady: "libs/domReady",
        text: "libs/text",
        json: "libs/json",
    }
});

define(function(require, exports, module) {
    "use strict";

    var App = require("app");
    var state = {};

    $.ajax({
        get: "GET",
        url: App.stateUri,
        complete: function(response) {
            var AppModel = require("modules/outcomes/models/app");
            var Outcomes = require("modules/outcomes/outcomes");
            var State = require("modules/common/models/state");

            state = response.responseJSON;
            state = new State(state);
            App.model = new AppModel();
            App.router = new Outcomes.Router({ state: state });
            Backbone.history.start({ root: App.root });
        }
    });
});
