// modules/outcomes/application.js
define(function(require, exports, module) {

    var Marionette = require("marionette");
    var ConfigModel = require("modules/outcomes/models/config");

    var OutcomesApplication = Marionette.Application.extend({

        regions: {
            appRegion: "#container"
        },

        navigate: function(route, options) {
            options || (options = {});
            Backbone.history.navigate(route, options);
        },

        getCurrentRoute: function() {
            return Backbone.history.fragment;
        },

        activateView: function(view) {
            this.rootView.mainRegion.show(view);
        },

        deactivateView: function() {
            this.rootView.mainRegion.empty();
        },

        startSubApp: function(appName, args) {
            var currentApp = appName ? this.module(appName) : null;
            if (this.currentApp === currentApp) { return; }

            if (this.currentApp) {
                this.currentApp.stop();
            }

            this.currentApp = currentApp;
            if (currentApp) {
                currentApp.start(args);
            }
        },

        getFilters: function() {
            return this.getOption("filters").filters;
        },

        getFilter: function(filter) {
            if (!this.hasFilter(filter)) throw 'Filter "'+filter+'" could not be found.';

            return this.getFilters()[filter];
        },

        getFilterNames: function() {
            return Object.keys(this.getFilters());
        },

        getAllowedFilters: function(fieldType) {
            var allowed = [];
            var self = this;
            this.getFilterNames().forEach(function(aFilter) {
                if (self.filterAllowsType(aFilter, fieldType)) {
                    allowed.push(aFilter);
                }
            });

            return allowed;
        },

        getFilterTypes: function(filter) {
            return this.getFilter(filter).types;
        },

        filterAllowsType: function(filter, type) {
            var found = false;
            var types = this.getFilterTypes(filter);
            types.forEach(function(fType) {
                if (fType == type) { found = true; }
            });

            return found;
        },

        hasFilter: function(filter) {
            var found = false;
            this.getFilterNames().forEach(function(aFilter) {
                if (aFilter == filter) { found = true; }
            });

            return found;
        },

        setExportFormat: function(format) {
            this.getOption("config").setExportFormat(format);
        }
    });


    var outcomes = new OutcomesApplication();

    outcomes.on("before:start", function(options) {

        // This should be pluggable from the options array...
        options.config || (options.config = new ConfigModel());

        // Need some more validation...
        if (!options.state || !options.filters) {
            throw "State and filters must be supplied to start outcomes.";
        }

        this.mergeOptions(options, [
            "state", 
            "filters", 
            "config", 
            "rootUrl", 
            "stateUrl", 
            "filterUrl",
            "filteredUrl",
            "translatedUrl",
            "generateUrl",
            "downloadUrl"
        ]);

        // Create layout view.
        var LayoutView = require("modules/outcomes/views/layout");
        var layoutView = this.rootView = new LayoutView();
        this.appRegion.show(layoutView);

        layoutView.mainRegion.on("show", function(view, region) {
            region.$el.addClass("animated");
        });
    });

    outcomes.on("start", function(options) {
        // Initialize backbone history, if possible.
        if (Backbone.history) {
            Backbone.history.start();
            this.trigger("targets:list");
        }
    });

    return outcomes;
});
