// util.js
define([
    'jquery',
    'underscore',
    'backbone'
], function($, _, Backbone) {
    var body = $('body');
    var overlay = $('#overlay').addClass('animated bounceInDown');
    var animEvents = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";

    return {

        getBody: function() {
            return body;
        },
        lock: function() {
            overlay.removeClass('fadeOutUp').addClass('bounceInDown').show().one(animEvents, function() {
                $(this).removeClass('bounceInDown');
            });
        },
        unlock: function() {
            overlay.removeClass('bounceInDown').addClass('fadeOutUp').one(animEvents, function() {
                $(this).removeClass('fadeOutUp');
                $(this).hide();
            });
        },

        debug: {
            view: null,
            history: [],

            setView: function(view) {
                this.view = view;
                return this;
            },

            _hasDebug: function() {
                return this.view ? true : false;
            },

            // CONSOLE METHODS
            // ================

            log: function(message) {
                this.add.apply(this, arguments);
                if (this._hasDebug() && window.console) console.log(Array.prototype.slice.call(arguments));
            },

            add: function(message) {
                this.history.push(arguments);
            },

            get: function(offset) {
                return this.history[offset];
            },

            count: function() {
                return this.history.length;
            },

            latest: function() {
                return this.get(this.count() - 1);
            },

            list: function(message) {
                if (window.console) {
                    this.history.forEach(function(item, index) {
                        console.log((index+1) + ': ', Array.prototype.slice.call(item));
                    });
                }
            },

            clear: function(clearConsole) {
                this.history = [];
                if (window.console && clearConsole) {
                    console.clear();
                }
            },


            // DEBUGGER METHODS
            // =================

            show: function() {
                this.toggle(true);
            },

            hide: function() {
                this.toggle(false);
            },

            toggle: function(fade) {
                if (!this._hasDebug()) return;
                this.view.$el.fadeToggle(fade);
            }
        }

    };
});