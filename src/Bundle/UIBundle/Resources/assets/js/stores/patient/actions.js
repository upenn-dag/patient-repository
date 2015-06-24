'use strict';

var Constants = require('./constants');
var Dispatcher = require('./dispatcher');

module.exports = {
  load() {
    Dispatcher.dispatch({
      type: Constants.LOAD
    });
  },

  refresh() {
    Dispatcher.dispatch({
      type: Constants.REFRESH
    });
  },

  resetCriteria() {
    Dispatcher.dispatch({
      type: Constants.RESET_CRITERIA
    });
  },

  select(patientId) {
    Dispatcher.dispatch({
      type: Constants.SELECT,
      id: patientId
    });
  },

  setCriteria(criteria) {
    // TODO: Validate receipt of object
    criteria = criteria || {};
    Dispatcher.dispatch({
      type: Constants.SET_CRITERIA,
      criteria: criteria
    });
  },

  setCriteriaByKey(key, value) {
    Dispatcher.dispatch({
      type: Constants.SET_CRITERIA_BY_KEY,
      key: key,
      value: value
    });
  },

  setSortKey(key, direction) {
    Dispatcher.dispatch({
      type: Constants.SET_SORT_KEY,
      key: key,
      direction: direction || 'asc'
    });
  }
};
