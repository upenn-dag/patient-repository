// modules/outcomes/outcomes.js
define(function(require, exports, module) {

    // CONSTANTS
    var ANIMATION_EVENTS = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";


    // UTILITIES
    require("bootstrap");
    var app = require("app");
    var Utils = require("modules/outcomes/utils");
    var Notifier = Utils.notifier;


    // APP EXTENSIONS
    app.filterExists = function(filter) {
        var found = false;
        app.availableFilters.forEach(function(aFilter) {
            if (aFilter == filter) {
                found = true;
            }
        });

        return found;
    }

    app.filterTypes = function(filter) {
        if (!app.filterExists(filter)) throw 'Filter "'+filter+'" could not be found.';

        return app.filterData.filters[filter].types;
    }

    app.filterAllowsType = function(filter, type) {
        var found = false;
        var filterTypes = app.filterTypes(filter);
        filterTypes.forEach(function(fType) {
            if (fType == type) {
                found = true;
            }
        });

        return found;
    }

    app.allowedFilters = function(fieldType) {
        var allowed = [];
        app.availableFilters.forEach(function(aFilter) {
            if (app.filterAllowsType(aFilter, fieldType)) {
                allowed.push(aFilter);
            }
        });

        return allowed;
    }

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


    // ROUTER
    module.Router = Backbone.Router.extend({
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

            this.headerView = new module.Views.Header({ router: this }).render();
            this.appView = new module.Views.App({ router: this, model: app.model }).render();
            this.app = app.model;
            this.state = options.state;
        },

        default: function() {
            return this.navigate("target", { trigger: true, replace: true });
        },

        target: function() {
            this.trigger("routeChange", "target");
            this.targetsView = this.targetsView || new module.Views.Targets({ collection: this.state.getObjects() });
            this.setCurrentView(this.targetsView);
        },

        filters: function() {
            if (!this.app.filterable()) {
                Notifier.navigationWarning("Unable to filter until a target has been selected.");
                return this.navigate("target", { trigger: true, replace: true });
            }

            this.trigger("routeChange", "filters");
            this.filtersView = this.filtersView || new module.Views.Filters({ collection: this.app.getFilters() }).render();
            this.setCurrentView(this.filtersView);
        },

        transformations: function() {
            if (!this.app.transformable()) {
                Notifier.navigationWarning("Unable to transform until data has been filtered.");
                return this.navigate("filters", { trigger: true, replace: true });
            }

            this.trigger("routeChange", "transformations");
            this.transformationsView = this.transformationsView || new module.Views.Transformations();
            this.setCurrentView(this.transformationsView);
        },

        export: function() {
            if (!this.app.exportable()) {
                Notifier.navigationWarning("Not enough data to export.");
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


    // VIEWS
    module.Views = {};

    module.Views.App = Backbone.View.extend({
        el: document.getElementById('content')
    });

    module.Views.Header = Backbone.View.extend({
        el: document.getElementById('header'),
        template: _.template(require("text!modules/outcomes/templates/header.html")),

        events: {
            "click a": "disableNavigation"
        },

        initialize: function(options) {
            // We had to create a custom routeChange event on the router
            // otherwise, the route events will be called out of "logical order".
            this.listenTo(options.router, "routeChange", this.enable);
        },

        enable: function(route) {
            if (!route) return;
            var links = $("#header [data-route]");
            var active = $("#header [data-route="+route+"]");
            var offset = links.index(active);

            if (-1 < offset) {
                links.slice(0, offset+1).parent().removeClass("disabled active");
                links.slice(offset+1, (links.length)).parent().removeClass("active").addClass("disabled");
                active.parent().addClass("active");
            }
        },

        disableNavigation: function(event) {
            event.preventDefault();
            event.stopPropagation();
            return false;
        },

        render: function() {
            this.el.innerHTML = this.template({});

            return this;
        }
    });

    module.Views.Target = Backbone.View.extend({
        model: require("modules/common/models/object"),
        template: _.template(require("text!modules/outcomes/templates/target.html")),

        events: {
            "click": "activate"
        },

        initialize: function() {
            this.listenTo(app.model, "change:object", this.render);
            this.render();
        },

        activate: function() {
            if (this.model.isPrototyped()) {
                var model = this.model;
                var buttons = [{ "data-handler": "destroy", text: "No" }];
                model.getPrototypes().each(function(prototype) {
                    buttons.push({
                        "data-role" : "yes",
                        "data-target-prototype": prototype.get("name"),
                        text: _.humanize(_.underscore(prototype.get("name")))
                    });
                });

                Notifier.notify({
                    dialog: true,
                    modal: true,
                    type: "info",
                    title: "Select a prototype",
                    message: "The object you selected is prototyped, would you like to limit your results to a specific prototype?",
                    buttons: buttons,
                })
                .on("click:yes", function(event) {
                    var prototype = $(event.target).data("target-prototype");
                    app.model.setObjectPrototype(model.getPrototype(prototype));
                    this.destroy();
                })
            }

            app.model.setObject(this.model);
        },

        render: function() {
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        }
    });

    module.Views.Targets = Backbone.View.extend({
        el: document.getElementById('targets-container'),
        collection: require("modules/common/collections/objects"),
        template: _.template(require("text!modules/outcomes/templates/targets.html")),

        initialize: function() {
            this.listenTo(this.collection, "change:active", this.showNext);
            this.render();
        },

        showNext: function(target, active) {
            this.$el.find(".section-next").show();
        },

        render: function() {
            this.$el.html(this.template({}));

            // Hide header button by default.
            this.$el.find(".section-next").hide();

            var $el = this.$el.find('#targets');
            this.collection.each(function(target) {
                var target = new module.Views.Target({ model: target });
                $el.append(target.$el);
            });

            return this;
        }
    });

    var FilterModel = require("modules/outcomes/models/filter");
    module.Views.Filter = Backbone.View.extend({
        tagName: "li",
        className: "list-group-item",
        model: FilterModel,
        template: _.template(require("text!modules/outcomes/templates/filter.html")),

        events: {
            "click .field-filter-configure" : "configure",
        },

        initialize: function() {
            this.listenTo(this.model, "change:state", this._handleStateChange);
        },

        _handleStateChange: function(model, state) {
            var previousState = model.previous("state");

            switch (previousState) {
                case model.getActiveState(): this.$el.removeClass("list-group-item-success"); break;
                case model.getDisabledState(): this.$el.removeClass("list-group-item-warning"); break;
            }

            switch (state) {
                case model.getActiveState(): this.$el.addClass("list-group-item-success"); break;
                case model.getDisabledState(): this.$el.addClass("list-group-item-warning"); break;
            }
        },

        configure: function() {
            var field = this.model.get("field");
            var fieldType = field.get("type")
            var allowedFilters = app.allowedFilters(fieldType);

            if (0 == allowedFilters.length) {
                Notifier.navigationWarning('There are no filters capable of handling "'+fieldType+'" fields.');
                this.model.disable();
                return;
            }

            alert("Configuring filter");
            this.model.activate();
        },

        render: function() {
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        }
    });

    // Right now, we only allow a single filter...Later, we will allow more.
    module.Views.Field = Backbone.View.extend({
        model: require("modules/common/models/field"),
        template: _.template(require("text!modules/outcomes/templates/field.html")),
        filterList: null,

        events: {
            "click .field-filter-add": "addFilter",
            "click .field-filter-remove": "removeFilter",
        },

        initialize: function() {
            this.listenTo(this.model, "change:filter", this._handleFilterChange);
        },

        _handleFilterChange: function(model, filter) {
            this.renderFilter();
        },

        addFilter: function() {
            if (!!this.model.get("filter")) {
                alert("We currently only allow on filter per field");
                return;
            }

            var model = new FilterModel();
            model.set("field", this.model);
            this.model.set("filter", model);
        },

        removeFilter: function() {
            this.model.set("filter", null);
        },

        renderFilter: function() {
            this.filterList.html("");
            var filter = this.model.get("filter");
            if (filter) {
                var filterView = new module.Views.Filter({ model: filter }).render();
                this.filterList.append(filterView.$el);
            }
        },

        render: function() {
            this.$el.html($(this.template(this.model.toJSON())));
            this.filterList = this.$el.find(".field-filters");

            return this;
        }
    });

    module.Views.Filters = Backbone.View.extend({
        el: document.getElementById('filters-container'),
        template: _.template(require("text!modules/outcomes/templates/filters.html")),

        events: {
            "click #preview-base-dataset": "_handleDatasetPreview",
        },

        _handleDatasetPreview: function() {
            event.preventDefault();
            this.preview();
            return false;
        },

        loadDataset: function() {
            var config = app.model.getConfig();
            var jqxhr = $.ajax({
                type: "POST",
                dataType: "json",
                url: app.filteredUri,
                data: JSON.stringify(config),
            });

            jqxhr.done(function(response) {
                $("#base-dataset").html(JSON.stringify(response));
            });
        },

        getFields: function() {
            var object = app.model.getObject();

            if (app.model.hasObjectPrototype()) {
                return object.getFields();
            } else {
                return object.getFields();
            }
        },

        preview: function() {
            this.loadDataset();
        },

        render: function() {
            var fields = this.getFields().common();

            this.$el.html(this.template({ target: app.model.getObject().toJSON(), fields: fields.toJSON() }));

            // Hide header button by default.
            this.$el.find(".section-next").hide();
            this.$el.find("a[data-target='#fields-help']").tab("show");

            // Render active fields...
            var $elFields = this.$el.find("#fields");
            fields.each(function(field) {
                var field = new module.Views.Field({ model: field }).render();
                $elFields.append(field.$el);
            });

            return this;
        }
    });

    module.Views.Transformations = Backbone.View.extend({
        el: document.getElementById('transformations-container'),
        template: _.template(require("text!modules/outcomes/templates/transformations.html")),

        initialize: function() {
            this.render();
        },

        render: function() {
            this.$el.html(this.template({}));

            return this;
        }
    });

    module.Views.Export = Backbone.View.extend({
        el: document.getElementById('export-container'),
        template: _.template(require("text!modules/outcomes/templates/export.html")),

        initialize: function() {
            this.render();
        },

        render: function() {
            this.$el.html(this.template({}));

            return this;
        }
    });


    // Publicly accessible
    exports.Router = module.Router;
});
