'use strict';

var React = require('react/addons');
var Immutable = require('immutable');
var Constants = require('./constants');
var Dispatcher = require('./dispatcher');
var Utils = require('./utils');
var EventEmitter = require('events').EventEmitter;
var assign = require('object-assign');

var CHANGE_EVENT = 'inspector-change';
var inspectors = Immutable.OrderedMap();

var Store = assign({}, EventEmitter.prototype, {
  emitChange: function() {
    this.emit(CHANGE_EVENT);
  },

  addChangeListener: function(callback) {
    this.on(CHANGE_EVENT, callback);
  },

  removeChangeListener: function(callback) {
    this.removeListener(CHANGE_EVENT, callback);
  },

  get: function(id) {
    return inspectors.get(id);
  },

  getAll: function() {
    return inspectors;
  }
});

/**
 * Interface action hooks.
 */
Store.dispatchToken = Dispatcher.register(function(action) {

  switch (action.type) {

    case Constants.ADD:
      // Convert component data to a map object.
      action.inspector.componentData = Immutable.Map(action.inspector.componentData);

      var item = Immutable.Map(action.inspector);
      inspectors = inspectors.set(item.get('id'), item);
      Store.emitChange();
    break;

    case Constants.REMOVE:
      inspectors = inspectors.remove(action.id);
      Store.emitChange();
    break;

    case Constants.REMOVE_ALL:
      inspectors = inspectors.clear();
      Store.emitChange();
    break;

    // Only allows updating of componentData
    case Constants.UPDATE:
      inspectors = inspectors.setIn([action.id, 'componentData'], Immutable.Map(action.data));
      Store.emitChange();
    break;

    default:
      // Do nothing
  }

});

module.exports = Store;
