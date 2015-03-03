// modules/common/models/object.js
define(function(require, exports, module) {
    "use strict";

    var Backbone = require("backbone");
    var Field = require("modules/common/models/field");
    var Fields = require("modules/common/collections/fields");
    var Prototypes = require("modules/common/collections/prototypes");
    var ObjectModel = Backbone.Model.extend({
        idAttribute: "name",
        defaults: {
            active: false,
        },
        initialize: function(options) {
            var prototypes = new Prototypes();
            var fields = new Fields();
            var prototype;

            if (options.fields) {
                var fKeys = Object.keys(options.fields);
                for (var i = 0; i < fKeys.length; i++) {
                    fields.add(options.fields[fKeys[i]]);
                }
            }

            if (options.prototypes) {
                var pKeys = Object.keys(options.prototypes);
                for (var i = 0; i < pKeys.length; i++) {
                    prototype = new Field(options.prototypes[pKeys[i]]);
                    prototype.set("fields", fields);
                    prototypes.add(prototype);
                }
            }

            this.set("prototypes", prototypes);
            this.set("fields", fields);
        },
        isPrototyped: function() {
            return this.get("isPrototyped");
        },
        getPrototypes: function() {
            return this.get("prototypes");
        },
        getPrototype: function(name) {
            return this.getPrototypes().get(name);
        },
        getFields: function() {
            return this.get("fields");
        },
        getField: function(name) {
            return this.getFields().get(name);
        },

        activate: function() {
            this.set("active", true);
        },
        deactivate: function() {
            this.set("active", false);
        }
    });

    return ObjectModel;
});
