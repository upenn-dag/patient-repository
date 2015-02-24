// view/test/test.js
define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/test/test.html'
], function($, _, Backbone, testTestTemplate) {
    var TestTestView = Backbone.View.extend({
        el: 'div',
        render: function() {
            var data = {};

            this.$el.html(_.template(testTestTemplate, data));

            return this;
        }
    });

    return TestTestView;
});
