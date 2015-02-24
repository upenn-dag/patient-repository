// view/test/test.js
define([
    'jquery',
    'underscore',
    'backbone',
    'models/state',
    'text!templates/app.html',
    'views/debug'
], function($, _, Backbone, State, appTemplate, DebugView) {
    var AppView = Backbone.View.extend({
        el: $('#outcomes-application'),
        template: _.template(appTemplate),
        debug: false,
        debugView: null,
        state: null,
        initialize: function(options) {
            if (!options.state) {
                throw "Unable to initialize application view, state must be set";
            }

            this.debug = options.debug || false;
            this.debugView = new DebugView();
            this.model = new State(options.state);
        },
        render: function() {
            var data = {
                debug: this.isDebug()
            };

            this.$el.html(this.template(data));
            this.renderDebug();

            return this;
        },
        renderDebug: function() {
            if (this.isDebug()) {
                this.debugView.setElement($('#outcomes-debug'));
                this.debugView.render();
            }

            return this;
        },
        getState: function() {
            return this.state;
        },
        isDebug: function() {
            return this.debug;
        }
    });

    return AppView;
});
