// modules/outcomes/collections/translations.js
define(function(require, exports, module) {
    "use strict";

    var Backbone = require("backbone");
    var Translations = Backbone.Collection.extend({
        model: require("modules/outcomes/models/translation")
    });

    return Translations;
});
