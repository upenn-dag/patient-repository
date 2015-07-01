'use strict';

var Constants = require('./constants');
var Dispatcher = require('./dispatcher');

module.exports = {
  switchSubapplication: function(subApplication) {
    Dispatcher.dispatch({
      type: Constants.SWITCH_SUBAPPLICATION,
      subApplication: subApplication
    });
  }
};
