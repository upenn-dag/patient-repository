'use strict';

var Immutable = require('immutable');
var Constants = require('./constants');
var Dispatcher = require('./dispatcher');
var EventEmitter = require('events').EventEmitter;
var assign = require('object-assign');
var alert = window.alert;

var CHANGE_EVENT = 'accard-change';
var appList = {
  patient: 'patient',
  patients: 'patients',
  newPatient: 'new-patient'
};
var appState = Immutable.Map({
  subApplication: 'patients'
});

function validateSubapp(subApplication) {
  return !!subApplication && !!appList[subApplication.toString()];
}

var Store = assign({}, EventEmitter.prototype, {
  emitChange: function() {
    this.emit(CHANGE_EVENT);
  },

  addChangeListener: function(callback) {
    this.addListener(CHANGE_EVENT, callback);
  },

  removeChangeListener: function(callback) {
    this.removeListener(CHANGE_EVENT, callback);
  },

  get: function() {
    return appState;
  },

  getList: function() {
    return appList;
  },

  getSubapplication: function() {
    return appState.get('subApplication');
  }
});

/**
 * Interface action hooks.
 */
Store.dispatchToken = Dispatcher.register(function(action) {

  switch (action.type) {
    case Constants.SWITCH_SUBAPPLICATION:
      if (!validateSubapp(action.subApplication)) {
        throw 'Requested application "' + action.subApplication + '" is not currently registered';
      }
      var oldAppState = appState;
      appState = appState.set('subApplication', action.subApplication);

      // Only emit change if it actually changed.
      if (oldAppState !== appState) {
        Store.emitChange();
      }
    break;

    default:
      // Do nothing
  }

});

module.exports = Store;
