'use strict';

var Constants = require('./constants');
var Dispatcher = require('./dispatcher');

module.exports = {
  add: function(inspector) {
    Dispatcher.dispatch({
      type: Constants.ADD,
      inspector: inspector
    });
  },

  remove: function(id) {
    Dispatcher.dispatch({
      type: Constants.REMOVE,
      id: id
    });
  },

  removeAll: function() {
    Dispatcher.dispatch({
      type: Constants.REMOVE_ALL
    });
  },

  update: function(id, data) {
    Dispatcher.dispatch({
      type: Constants.UPDATE,
      id: id,
      data: data
    });
  }
};
