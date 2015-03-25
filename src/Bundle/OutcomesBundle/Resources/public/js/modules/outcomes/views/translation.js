// modules/outcomes/views/translation.js
define(function(require, exports, module) {
    "use strict";

    require("backbone");
    var Translation = require("modules/outcomes/models/translation");

    var TranslationView = Backbone.View.extend({
        template: _.template(require("text!modules/outcomes/templates/translation.html")),
        model: Translation,
        className: "translation",
        keyField: null,
        definitionField: null,
        panel: null,

        events: {
            "keyup .translation-key, .translation-definition": "_handleKeyup",
            "change .translation-key": "_handleKeyChange",
            "change .translation-definition": "_handleDefinitionChange",
        },

        initialize: function() {
            this.model.set("view", this);

            //this.listenTo(this.model, "change", this.render);
        },

        _handleKeyup: function() {
            if (this.keyField.val() && this.definitionField.val()) {
                this.panel.removeClass("panel-warning").addClass("panel-success");
            } else {
                this.panel.removeClass("panel-success").addClass("panel-warning");
            }

            this.panel.removeClass("panel-default");
        },

        _handleKeyChange: function() {
            this.model.set("key", this.keyField.val());
        },

        _handleDefinitionChange: function() {
            this.model.set("definition", this.definitionField.val());
        },

        remove: function() {
            this.$el.remove();
        },

        render: function() {
            this.$el.html(this.template(this.model.toJSON()));
            this.$el.data("translation", this.model);

            this.keyField = this.$el.find(".translation-key");
            this.definitionField = this.$el.find(".translation-definition");
            this.panel = this.$el.find(".panel");

            return this;
        }
    });

    return TranslationView;
});