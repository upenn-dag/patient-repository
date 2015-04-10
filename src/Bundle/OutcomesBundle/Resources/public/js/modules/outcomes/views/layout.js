// modules/outcomes/views/layout.js
define(function(require, exports, module) {

    require("marionette");

    var LayoutView = Marionette.LayoutView.extend({
        template: "#main-template",
        id: "app",
        regions: {
            mainRegion: "#main-container",
        },

        activate: function(view) {
            this.mainRegion.show(view, { preventDestroy: true });
        }
    });

    return LayoutView;
});
