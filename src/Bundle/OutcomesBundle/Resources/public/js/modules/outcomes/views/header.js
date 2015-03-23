// modules/outcomes/views/header.js
define(function(require, exports, module) {
    "use strict";

    require("backbone");
    var HeaderView = Backbone.View.extend({
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

    return HeaderView;
});