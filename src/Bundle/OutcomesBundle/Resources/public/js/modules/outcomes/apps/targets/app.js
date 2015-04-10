// modules/outcomes/apps/targets/app.js
define(function(require, exports, module) {

    require("jquery.serialize");
    require("marionette");
    require("bootstrap");
    require("bootstrap.table");
    require("backbone");

    var outcomes = require("modules/outcomes/application");
    var Utils = require("modules/outcomes/utils");

    var createDatasetTable = function(dataset) {
        if (0 === Utils.objectSize(dataset)) {
            return;
        }

        var columns = Object.keys(dataset[0]);
        var table   = $("<table class='table table-hover table-condensed'><thead><tr/>");
        var anchor  = table.find("tr").first();

        for (var i = 0; i < columns.length; i++) {
            anchor.append(
                $("<th data-field='"+columns[i]+"' data-title='"+_.humanize(columns[i])+"'>")
            );
        };

        return $(table).bootstrapTable({ data: dataset, striped: true });
    };

    outcomes.module("TargetsApp", { startWithParent: false });


    outcomes.module("TargetsApp.List", function(List) {

        var TargetModel = require("modules/common/models/object");
        var NoTargetsView = Marionette.ItemView.extend({
            template: _.template(require("text!modules/outcomes/apps/targets/list/templates/noTargets.html")),
        });


        List.View = {

            Layout: Marionette.LayoutView.extend({
                template: _.template(require("text!modules/outcomes/apps/targets/list/templates/layout.html")),
                regions: {
                    headerRegion: "#targets-header",
                    targetsRegion: "#targets",
                }
            }),

            Header: Marionette.ItemView.extend({
                template: _.template(require("text!modules/outcomes/apps/targets/list/templates/header.html")),
                defaults: {
                    "showHeader": false
                },
                ui: {
                    "next":       ".section-next",
                    "navigation": "#targets-next"
                },
                triggers: {
                    "click @ui.next": "targets:filter"
                },
                initialize: function() {
                    this.options = _.extend({}, this.defaults, this.options);
                },
                onRender: function() {
                    this.toggleNavigation(this.options.showHeader);
                },
                toggleNavigation: function(val) {
                    this.ui.navigation.toggle(val);
                }
            }),

            Target: Marionette.ItemView.extend({
                template: _.template(require("text!modules/outcomes/apps/targets/list/templates/target.html")),
                model: TargetModel,
                ui: {
                    "target": ".target"
                },
                triggers: {
                    "click": "targets:select"
                },
                initialize: function() {
                    this.listenTo(this.model, "change:active", this.toggle);
                },
                toggle: function() {
                    this.ui.target.toggleClass("active");
                }
            })
        };

        List.View.Targets = Marionette.CollectionView.extend({
            template: _.template("<div id='targets-cont'></div>"),
            emptyView: NoTargetsView,
            childView: List.View.Target,
            childViewContainer: '#targets-cont'
        });

        List.Controller = {

            listTargets: function() {
                var View = List.View;
                var config = outcomes.getOption("config");
                var active = null;
                var objects = outcomes.getOption("state").getObjects();
                var layoutView = new View.Layout();
                var headerView = new View.Header({ showHeader: config.hasObject() });
                var targetsView = new View.Targets({ collection: objects });

                layoutView.on("render", function() {
                    layoutView.headerRegion.show(headerView);
                    layoutView.targetsRegion.show(targetsView);
                });

                headerView.on("targets:filter", function() {
                    // TODO: Validate target has been selected!
                    outcomes.trigger("targets:filter");
                });

                targetsView.on("childview:targets:select", function(childView, data) {
                    if (active) { active.deactivate(); }

                    var model = active = data.model;

                    // If model is prototyped, select it.
                    if (model.isPrototyped()) {
                        var buttons = [{ "data-handler": "destroy", text: "No" }];
                        model.getPrototypes().each(function(prototype) {
                            buttons.push({
                                "data-role" : "yes",
                                "data-target-prototype": prototype.get("name"),
                                text: _.humanize(_.underscore(prototype.get("name")))
                            });
                        });

                        Utils.notifier.notify({
                            dialog: true,
                            modal: true,
                            type: "info",
                            title: "Select a prototype",
                            message: "The object you selected is prototyped, would you like to limit your results to a specific prototype?",
                            buttons: buttons,
                        })
                        .on("click:yes", function(event) {
                            var prototype = $(event.target).data("target-prototype");
                            config.setObjectPrototype(model.getPrototype(prototype));
                            this.destroy();
                        })
                    }

                    // Perform actual object setup.
                    model.activate();
                    config.setObject(model);

                    // Show the navigation.
                    layoutView.headerRegion.currentView.toggleNavigation(true);
                });

                outcomes.activateView(layoutView);
            }
        };

        return List;
    });


    outcomes.module("TargetsApp.Filter", function(Filter) {
        
        var ConfigView = require("modules/outcomes/apps/targets/filter/views/config");
        var FilterModel = require("modules/outcomes/models/filter");
        var FiltersCollection = require("modules/outcomes/collections/filters");
        var NoFieldsView = Marionette.ItemView.extend({
            template: _.template(require("text!modules/outcomes/apps/targets/filter/templates/noFields.html")),
        });

        Filter.View = {

            Layout: Marionette.LayoutView.extend({
                template: _.template(require("text!modules/outcomes/apps/targets/filter/templates/layout.html")),
                regions: {
                    headerRegion: "#filters-header",
                    fieldsRegion: "#fields",
                }
            }),

            Header: Marionette.ItemView.extend({
                template: _.template(require("text!modules/outcomes/apps/targets/filter/templates/header.html")),
                ui: {
                    "next":    ".section-next",
                    "preview": "#preview-base-dataset",
                },
                triggers: {
                    "click @ui.next":    "targets:translate",
                    "click @ui.preview": "targets:preview:base"
                }
            }),

            Filter: Marionette.ItemView.extend({
                template: _.template(require("text!modules/outcomes/apps/targets/filter/templates/filter.html")),
                tagName: "li",
                className: "list-group-item",
                model: FilterModel,
                configView: null,

                ui: {
                    "remove":    ".field-filter-remove",
                    "configure": ".field-filter-configure",
                    "modal":     ".configuration-modal",
                    "config":    ".configuration-body",
                    "save":      ".configuration-save"
                },

                events: {
                    "click @ui.remove":    "removeFilter",
                    "click @ui.configure": "configure",
                    "click @ui.save":      "save"
                },

                initialize: function() {
                    this.listenTo(this.model, "change", this.render);
                },

                removeFilter: function() {
                    this.model.destroy();
                },

                save: function() {
                    var form = this.ui.config.find(".configuration-form");
                    var data = form.serializeJSON();

                    this.model.set({
                        type: data.type,
                        options: data.options,
                        name: _.humanize(data.type),
                        state: this.model.getActiveState(),
                    });

                    this.ui.modal.modal("hide");
                },

                configure: function() {
                    var field = this.model.get("field");
                    var fieldType = field.get("type")
                    var allowedFilters = outcomes.getAllowedFilters(fieldType);

                    // If no filters work here, throw an error.
                    if (0 == allowedFilters.length) {
                        Utils.notifier.navigationWarning('There are no filters capable of handling "'+fieldType+'" fields.');
                        this.model.disable();
                        return;
                    }

                    // Create the config view for this action.
                    this.configView = this.configView || new ConfigView({ model: this.model }).render();

                    // Run configuration at the field level, now that we're setup.
                    this.ui.config.html(this.configView.$el)
                    this.ui.modal.modal("show");
                },

                onRender: function() {
                    this.$el.addClass("state-"+this.model.get("state"));
                }
            })
        };

        Filter.View.Field = Marionette.CompositeView.extend({
            template: _.template(require("text!modules/outcomes/apps/targets/filter/templates/field.html")),
            childView: Filter.View.Filter,
            childViewContainer: "@ui.filters",

            ui: {
                "field":   ".field",
                "add":     ".field-filter-add",
                "remove":  ".field-remove",
                "filters": ".field-filters"
            },

            events: {
                "click @ui.add":    "addFilter",
                "click @ui.remove": "removeField"
            },

            addFilter: function() {
                this.collection.add(new FilterModel());
            },

            removeField: function() {
                this.model.set("removed", true);
                this.render();
            },

            onRender: function() {
                this.$el.toggle(!this.model.get("removed"));
            },

            // Override to collection view methods.
            buildChildView: function(child, ChildViewClass, childViewOptions) {
                child.set({ field: this.model });
                return new ChildViewClass(_.extend({ model: child }, childViewOptions));
            }
        });

        Filter.View.Fields = Marionette.CompositeView.extend({
            template: _.template(require("text!modules/outcomes/apps/targets/filter/templates/fields.html")),
            emptyView: NoFieldsView,
            childView: Filter.View.Field,
            childViewContainer: "#fields-cont",

            ui: {
                "dataset":      "#base-dataset",
                "datasetModal": "#base-dataset-modal",
                "datasetCount": "#base-dataset-count"
            },

            showPreview: function() {
                var self = this;
                var config = outcomes.getOption("config");
                var jqxhr = $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: outcomes.getOption("filteredUrl"),
                    data: JSON.stringify(config.serialize()),
                });

                jqxhr.done(function(response) {
                    var $table = createDatasetTable(response.data);

                    if (!$table) {
                        self.ui.datasetCount.html(0);
                        self.ui.dataset.html("No results were returned.");
                        return;
                    }

                    self.ui.datasetCount.html(response.count);
                    self.bootstrapTable = $table;
                    self.ui.dataset.html($table);
                });

                jqxhr.fail(function() {
                    self.ui.dataset.html("There was an error loading this dataset.");
                });

                this.ui.dataset.html("Loading...");
                this.ui.datasetModal.modal("show");
            },

            // Overrides to collection view methods.
            buildChildView: function(child, ChildViewClass, childViewOptions) {
                if (typeof child.get("initialized") == "undefined") {
                    child.set({
                        filters: new FiltersCollection(),
                        removed: false,
                        initialized: true
                    });
                }

                var options = _.extend({
                    model: child,
                    collection: child.get("filters")
                }, childViewOptions);

                return new ChildViewClass(options);
            }
        });

        Filter.Controller = {

            filterTargets: function(criterion) {
                var View       = outcomes.module("TargetsApp.Filter.View");
                var filters    = outcomes.getOption("filters");
                var fields     = outcomes.getOption("config").getObject().getFields();
                var layoutView = new View.Layout();
                var headerView = new View.Header();
                var fieldsView = new View.Fields({ collection: fields });

                layoutView.on("render", function() {
                    layoutView.headerRegion.show(headerView);
                    layoutView.fieldsRegion.show(fieldsView);
                });

                headerView.on("targets:preview:base", function() {
                    fieldsView.showPreview();
                });

                headerView.on("targets:translate", function() {
                    // TODO: Validate target has been selected!
                    outcomes.trigger("targets:translate");
                });

                outcomes.activateView(layoutView);
            }
        };

        return Filter;
    });


    outcomes.module("TargetsApp.Translate", function(Translate) {

        var TranslationsCollection = require("modules/outcomes/collections/translations");
        var TranslationModel = require("modules/outcomes/models/translation");
        var NoTranslationsView = Marionette.ItemView.extend({
            template: _.template(require("text!modules/outcomes/apps/targets/translate/templates/noTranslations.html")),
        });

        Translate.View = {

            Layout: Marionette.LayoutView.extend({
                template: _.template(require("text!modules/outcomes/apps/targets/translate/templates/layout.html")),
                regions: {
                    headerRegion: "#translations-header",
                    translationsRegion: "#translations",
                },
                ui: {
                    "preview": "#preview-translated-dataset"
                },
                triggers: {
                    "click @ui.preview": "targets:preview:translated"
                }
            }),

            Header: Marionette.ItemView.extend({
                template: _.template(require("text!modules/outcomes/apps/targets/translate/templates/header.html")),
                ui: {
                    "next":    "#translated-button-next",
                    "add":     "#add-translation"
                },
                triggers: {
                    "click @ui.next": "targets:export",
                    "click @ui.add":  "translation:add"
                }
            }),

            Translation: Marionette.ItemView.extend({
                template: _.template(require("text!modules/outcomes/apps/targets/translate/templates/translation.html")),
                ui: {
                    "key":        ".translation-key",
                    "definition": ".translation-definition",
                    "remove":     ".translation-remove",
                    "panel":      ".panel"
                },
                events: {
                    "click @ui.remove":      "removeTranslation",
                    "keyup @ui.key":         "_handleKeyup",
                    "keyup @ui.definition":  "_handleKeyup",
                    "change @ui.key":        "_handleKeyChange",
                    "change @ui.definition": "_handleDefinitionChange",
                },

                _handleKeyup: function() {
                    if (this.ui.key.val() && this.ui.definition.val()) {
                        this.ui.panel.removeClass("panel-warning").addClass("panel-success");
                    } else {
                        this.ui.panel.removeClass("panel-success").addClass("panel-warning");
                    }

                    this.ui.panel.removeClass("panel-default");
                },

                _handleKeyChange: function() {
                    this.model.set("key", this.ui.key.val());
                },

                _handleDefinitionChange: function() {
                    this.model.set("definition", this.ui.definition.val());
                },

                removeTranslation: function() {
                    this.model.destroy();
                }
            })
        };

        Translate.View.Translations = Marionette.CompositeView.extend({
            template: _.template(require("text!modules/outcomes/apps/targets/translate/templates/translations.html")),
            emptyView: NoTranslationsView,
            childView: Translate.View.Translation,
            childViewContainer: "#translations-cont",

            ui: {
                "dataset":      "#translated-dataset",
                "datasetModal": "#translated-dataset-modal",
                "datasetCount": "#translated-dataset-count"
            },

            onAddChild: function(childView) {
                childView.ui.key.focus();
            },

            showPreview: function() {
                var self = this;
                var config = outcomes.getOption("config");
                var jqxhr = $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: outcomes.getOption("translatedUrl"),
                    data: JSON.stringify(config.serialize()),
                });

                jqxhr.done(function(response) {
                    var $table = createDatasetTable(response.data);

                    if (!$table) {
                        self.ui.datasetCount.html(0);
                        self.ui.dataset.html("No results were returned.");
                        return;
                    }

                    self.ui.datasetCount.html(response.count);
                    self.bootstrapTable = $table;
                    self.ui.dataset.html($table);
                });

                jqxhr.fail(function() {
                    self.ui.dataset.html("There was an error loading this dataset.");
                });

                this.ui.dataset.html("Loading dataset...");
                this.ui.datasetModal.modal("show");
            },
        });

        Translate.Controller = {

            translateDataset: function() {
                var View = Translate.View;
                var layoutView = new View.Layout();
                var headerView = new View.Header();
                var translations = outcomes.getOption("config").getTranslations();
                var translationsView = new View.Translations({ collection: translations });

                layoutView.on("render", function() {
                    layoutView.headerRegion.show(headerView);
                    layoutView.translationsRegion.show(translationsView);
                });

                layoutView.on("targets:preview:translated", function() {
                    if (0 === translations.length) {
                        return Utils.notifier.notify({
                            type: "error",
                            ms: 5000,
                            modal: true,
                            hideOnClick: true,
                            title: "Dataset Generation Error!",
                            message: "You must first add a translation before you will be able to generate a dataset.",
                        });
                    }

                    translationsView.showPreview();
                });

                headerView.on("targets:export", function() {
                    // TODO: Validate target has been selected!
                    outcomes.trigger("targets:export");
                });

                headerView.on("translation:add", function() {
                    translations.add(new TranslationModel());
                });

                outcomes.activateView(layoutView);
            }
        };

        return Translate;
    });


    outcomes.module("TargetsApp.Export", function(Export) {

        Export.View = {
            Layout: Marionette.LayoutView.extend({
                template: _.template(require("text!modules/outcomes/apps/targets/export/templates/layout.html")),
                regions: {
                    headerRegion: "#export-header"
                },
                ui: {
                    "csv":      "#export-csv",
                    "xml":      "#export-xml",
                    "json":     "#export-json",
                    "download": "#export-download",
                },
                events: {
                    "click @ui.csv":  "activateCSV",
                    "click @ui.xml":  "activateXML",
                    "click @ui.json": "activateJSON",
                },
                triggers: {
                    "click @ui.download":  "targets:download",
                },

                _activateFormat: function(button) {
                    button.addClass("active");
                },

                _deactivateFormat: function(button) {
                    button.removeClass("active");
                },

                _activateDownload: function() {
                    this.ui.download.button("downloading");
                    this.ui.download.removeProp("disabled");
                },

                activateCSV: function() {
                    this._deactivateFormat(this.ui.xml);
                    this._deactivateFormat(this.ui.json);
                    this._activateFormat(this.ui.csv);
                    this.trigger("targets:export:csv");
                    this._activateDownload();
                },
                activateXML: function() { // Currently disabled
                    return;
                    this._deactivateFormat(this.ui.csv);
                    this._deactivateFormat(this.ui.json);
                    this._activateFormat(this.ui.xml);
                    this.trigger("targets:export:xml");
                    this._activateDownload();
                },
                activateJSON: function() { // Currently disabled
                    return;
                    this._deactivateFormat(this.ui.csv);
                    this._deactivateFormat(this.ui.xml);
                    this._activateFormat(this.ui.json);
                    this.trigger("targets:export:json");
                    this._activateDownload();
                }
            }),
            Header: Marionette.ItemView.extend({
                template: _.template(require("text!modules/outcomes/apps/targets/export/templates/header.html")),
                ui: {
                    "startOver": "#export-start-over"
                },
                triggers: {
                    "click @ui.startOver": "targets:reset",
                }
            })
        };

        Export.Controller = {

            exportDataset: function() {
                var View = Export.View;
                var layoutView = new View.Layout();
                var headerView = new View.Header();

                layoutView.on("render", function() {
                    layoutView.headerRegion.show(headerView);
                });

                headerView.on("targets:reset", function() {
                    var confirmed = confirm("This will erase all data and start over, are you sure?");
                    console.log(confirmed);
                    if (confirmed) {
                        outcomes.trigger("targets:reset");
                    }
                });

                layoutView.on("targets:download", function() {
                    var config = outcomes.getOption("config");
                    var jqxhr = $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: outcomes.getOption("generateUrl") + config.getExportFormat(),
                        data: JSON.stringify(config.serialize()),
                    });

                    jqxhr.done(function(response) {
                        var downloadUrl = outcomes.getOption("downloadUrl") + response.file;
                        var $iframe = $("<iframe src='"+downloadUrl+"' style='display:none;' class='target-iframe'/>");
                        $(".target-iframe").remove(); // Remove other downloads.
                        $("body").append($iframe);
                        layoutView.ui.download.button("reset");
                    });

                    jqxhr.fail(function() {
                        layoutView.ui.download.button("error");
                        alert("An unknown error has occurred, unable to download file.");
                    });
                });

                layoutView.on("targets:export:csv", function() {
                    outcomes.setExportFormat("csv");
                });

                layoutView.on("targets:export:xml", function() {
                    outcomes.setExportFormat("xml");
                });

                layoutView.on("targets:export:json", function() {
                    outcomes.setExportFormat("json");
                });

                outcomes.activateView(layoutView);
            }
        };

        return Export;
    });


    // Targets router.
    outcomes.module("Routers.TargetsApp", function(TargetsAppRouter) {

        TargetsAppRouter.Router = Marionette.AppRouter.extend({
            appRoutes: {
                "targets":   "listTargets",
                "filter":    "filterTargets",
                "translate": "translateDataset",
                "export":    "exportDataset"
            }
        });

        var executeAction = function(action, arg) {
            outcomes.startSubApp("TargetsApp");
            action(arg);
        };

        var API = {
            listTargets: function() {
                var Controller = outcomes.module("TargetsApp.List.Controller");
                executeAction(Controller.listTargets);
            },
            filterTargets: function() {
                var Controller = outcomes.module("TargetsApp.Filter.Controller");
                executeAction(Controller.filterTargets);
            },
            translateDataset: function() {
                var Controller = outcomes.module("TargetsApp.Translate.Controller");
                executeAction(Controller.translateDataset);
            },
            exportDataset: function() {
                var Controller = outcomes.module("TargetsApp.Export.Controller");
                executeAction(Controller.exportDataset);
            }
        };

        outcomes.on("targets:list", function() {
            outcomes.navigate("targets");
            API.listTargets();
        });

        outcomes.on("targets:filter", function() {
            var config = outcomes.getOption("config");

            if (!config.hasObject()) {
                alert("You haven't picked a target yet.");
                return;
            }

            outcomes.navigate("filters");
            API.filterTargets();
        });

        outcomes.on("targets:translate", function() {
            // Validate that we have one filter, if not show a warning message about how big the data is.
            outcomes.navigate("translate");
            API.translateDataset();
        });

        outcomes.on("targets:export", function() {
            outcomes.navigate("export");
            API.exportDataset();
        });

        outcomes.on("targets:reset", function() {
            var config = outcomes.getOption("config");
            config.clear().set(config.defaults);
            window.location.reload();
        });

        outcomes.on("start", function() {
            new TargetsAppRouter.Router({
                controller: API
            });
        });
    });

    return outcomes.TargetsAppRouter;
});
