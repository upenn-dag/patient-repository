// modules/common/collections/fields.js
define(function(require, exports, module) {
    "use strict";

    var Backbone = require("backbone");
    var FieldCollection = Backbone.Collection.extend({
        model: require("modules/common/models/field"),

        primary: function() {
            var idFields = this.where({ primary: true });

            return idFields.length > 1 ? new FieldCollection(idFields) : idFields[0];
        },

        required: function() {
            return this._subset({ nullable: false });
        },

        common: function() {
            return this._subset({ dynamic: false });
        },

        dynamic: function() {
            return this._subset({ dynamic: true });
        },

        _subset: function(options) {
            return new FieldCollection(this.where(options));
        }
    });

    return FieldCollection;
});
