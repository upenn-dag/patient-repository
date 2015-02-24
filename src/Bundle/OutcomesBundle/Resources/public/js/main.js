// main.js
define([ 'app', 'domReady!' ], function(App) {
    var initialize = function(state, debug) {
        App.initialize(state, debug);

        // If we're in debug mode, set up some shortcuts for the console.
        if (debug) {
            var util = require('util');

            window.outcomes = {
            	app: App,
                util: util,
                rawState: state,
                state: App.view.model,
            };
        }
    };

    return {
        initialize: initialize
    };
});