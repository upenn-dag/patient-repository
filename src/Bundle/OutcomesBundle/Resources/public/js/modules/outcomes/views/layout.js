// modules/outcomes/views/layout.js
define(function(require, exports, module) {

    require("marionette");

    var LayoutView = Marionette.LayoutView.extend({
        template: "#main-template",
        id: "app",
        regions: {
            mainRegion: "#main-container",
            // targetsRegion: "#targets-container",
            // filtersRegion: "#filters-container",
            // translationsRegion: "#translations-container",
            // exportRegion: "#export-container"
        },

        activate: function(view) {
            this.mainRegion.show(view, { preventDestroy: true });
        }
    });

    return LayoutView;
});
