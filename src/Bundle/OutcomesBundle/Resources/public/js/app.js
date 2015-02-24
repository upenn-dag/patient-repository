// app.js
define([
    'backbone',
    'routers/outcomes',
    'views/app'
], function(Backbone, Workspace, AppView) {
    var initialize = function(state, debug) {
        this.router = new Workspace();
        Backbone.history.start();
        this.view = new AppView({ state: state, debug: debug }).render();
    }

    return {
        initialize: initialize
    };
});