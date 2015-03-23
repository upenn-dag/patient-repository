// modules/outcomes/views/app.js
define(function(require, exports, module) {
    "use strict";

    require("backbone");
    var AppView = Backbone.View.extend({
        el: document.getElementById('content')
    });

    return AppView;
});