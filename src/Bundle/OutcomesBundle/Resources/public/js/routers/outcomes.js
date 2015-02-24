// routers/outcomes.js
define([
    'jquery',
    'underscore',
    'backbone',
    'views/test/test'
], function($, _, Backbone) {
    'use strict';

    var OutcomesRouter = Backbone.Router.extend({
        routes: {
            '': 'targetAction',
            '*actions': 'defaultAction'
        },

        currentView: null,

        targetAction: function() {
            $('#content').html('Main View!!!');
        },

        defaultAction: function(actions) {
            console.log('No route matched:', actions);
        },

        __render: function() {
            console.log(this.currentView.render().el);
            $('#content').html(this.currentView.render().el);
        }
    });

    return OutcomesRouter;
});