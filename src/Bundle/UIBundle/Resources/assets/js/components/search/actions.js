'use strict';

var Search = require('./constants');
var Dispatcher = require('./dispatcher');

module.exports = {
  clear: function() {
    Dispatcher.dispatch({
      type: Search.CLEAR
    });
  },

  search: function(term) {
    Dispatcher.dispatch({
      type: Search.SEARCH,
      term: term || ''
    });
  }
};
