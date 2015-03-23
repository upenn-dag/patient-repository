// modules/outcomes/router.js
define(function(require, exports, module) {
    "use strict";

    // Constants
    var ANIMATION_EVENTS = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";

    // Assets
    var app = require("app");
    var Utils = require("modules/outcomes/utils");
    var HeaderView = require("modules/outcomes/views/header");
    var AppView = require("modules/outcomes/views/app");
    var TargetsView = require("modules/outcomes/views/targets");
    var FiltersView = require("modules/outcomes/views/filters");

    var Router = Backbone.Router.extend({
        routes: {
            "target":          "target",
            "filters":         "filters",
            "transformations": "transformations",
            "export":          "export",
            "*path":           "default"
        },

        appView: null,
        headerView: null,
        currentView: null,
        targetsView: null,
        filtersView: null,
        transformationsView: null,
        exportView: null,

        app: null,
        state: null,

        initialize: function(options) {
            if (!options.state || !app.model) {
                throw "State & model must be provided to the router, none found.";
            }

            this.headerView = new HeaderView({ router: this }).render();
            this.appView = new AppView({ router: this, model: app.model }).render();
            this.app = app.model;
            this.state = options.state;
        },

        default: function() {
            return this.navigate("target", { trigger: true, replace: true });
        },

        target: function() {
            this.trigger("routeChange", "target");
            this.targetsView = this.targetsView || new TargetsView({ collection: this.state.getObjects() });
            this.setCurrentView(this.targetsView);
        },

        filters: function() {
            if (!this.app.filterable()) {
                Utils.notifier.navigationWarning("Unable to filter until a target has been selected.");
                return this.navigate("target", { trigger: true, replace: true });
            }

            this.trigger("routeChange", "filters");
            this.filtersView = this.filtersView || new FiltersView({ collection: this.app.getFilters() }).render();
            this.setCurrentView(this.filtersView);
        },

        transformations: function() {
            if (!this.app.transformable()) {
                Utils.notifier.navigationWarning("Unable to transform until data has been filtered.");
                return this.navigate("filters", { trigger: true, replace: true });
            }

            this.trigger("routeChange", "transformations");
            this.transformationsView = this.transformationsView || new module.Views.Transformations();
            this.setCurrentView(this.transformationsView);
        },

        export: function() {
            if (!this.app.exportable()) {
                Utils.notifier.navigationWarning("Not enough data to export.");
                return this.navigate("transformations", { trigger: true, replace: true });
            }

            this.trigger("routeChange", "export");
            this.exportView = this.exportView || new module.Views.Export().render();
            this.setCurrentView(this.exportView);
        },

        setCurrentView: function(view) {
            var inEvent = "fadeInDown";
            var outEvent = "fadeOutDown";

            if (this.currentView) {
                this.currentView.$el
                    .removeClass(inEvent)
                    .addClass("animated "+outEvent).one(ANIMATION_EVENTS, function() {
                        $(this).removeClass("animated "+outEvent);
                        view.$el
                            .removeClass(outEvent)
                            .addClass("animated "+inEvent).one(ANIMATION_EVENTS, function() {
                                $(this).removeClass(inEvent);
                            });
                    });
            } else {
                view.$el.addClass("animated "+inEvent).one(ANIMATION_EVENTS, function() {
                    $(this).removeClass(inEvent);
                });
            }

            this.currentView = view;
        }
    });

    return Router;
});