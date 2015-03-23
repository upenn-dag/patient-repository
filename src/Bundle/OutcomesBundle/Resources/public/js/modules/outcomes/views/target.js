// modules/outcomes/views/target.js
define(function(require, exports, module) {
    "use strict";

    require("backbone");

    // I'm not sure I want the app object in here...
    var app = require("app");
    var Utils = require("modules/outcomes/utils");

    var Target = Backbone.View.extend({
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

    return Target;
});
