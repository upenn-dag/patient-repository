'use strict';

var Immutable = require('immutable');
var EventEmitter = require('events').EventEmitter;
var assign = require('object-assign');
var API = require('./../../api');
var Routing = require('./../../routing').Routing;
var Constants = require('./constants');
var Dispatcher = require('./dispatcher');

var PatientModel = Immutable.Record({
  "id": null,
  "mrn": null,
  "firstName": null,
  "lastName": null,
  "gender": null,
  "race": null,
  "dateOfBirth": null,
  "dateOfDeath": null,
  "selected": false
});

var CriteriaModel = Immutable.Record({
  'mrn': null,
  'firstName': null,
  'lastName': null,
  'dateOfBirth': null,
  'fromDate': null,
  'toDate': null
});

var page, limit, pages, total, xhr, currentPatientId;
var CHANGE_EVENT = 'patient-change';
var CURRENT_EVENT = 'current-patient-change';
var patients = Immutable.List();
var criteria = new CriteriaModel();
var sortKey = 'id';
var sortDirection = 'desc';

var Store = assign({}, EventEmitter.prototype, {
  emitChange() {
    this.emit(CHANGE_EVENT);
  },

  emitCurrentPatientChange() {
    this.emit(CURRENT_EVENT);
  },

  addChangeListener(callback) {
    this.addListener(CHANGE_EVENT, callback);
  },

  removeChangeListener(callback) {
    this.removeListener(CHANGE_EVENT, callback);
  },

  addCurrentPatientListener(callback) {
    this.addListener(CURRENT_EVENT, callback);
  },

  removeCurrentPatientListener(callback) {
    this.removeListener(CURRENT_EVENT, callback);
  },

  createShowURL: createShowURL,
  createNewURL: createNewURL,

  get(id) {
    return find(id);
  },

  getByIndex(index) {
    return patients.get(index);
  },

  getAll() {
    return patients;
  },

  getCurrentPatientId() {
    return currentPatientId;
  },

  getCurrentPatient() {
    return currentPatientId ? this.get(currentPatientId) : null;
  },

  has(id) {
    return !!find(id);
  },

  hasCurrentPatient() {
    return currentPatientId ? this.has(currentPatientId) : false;
  },

  getSortKey() {
    return sortKey;
  },

  getSortDirection() {
    return sortDirection;
  },

  getOppositeSortDirection() {
    return 'desc' === sortDirection ? 'asc' : 'desc';
  },

  getPage() {
    return page;
  },

  getLimit() {
    return limit;
  },

  getPages() {
    return pages;
  },

  getTotal() {
    return total;
  },

  getCriteria() {
    return criteria;
  },

  isFiltered() {
    return !!criteria.mrn || !!criteria.firstName || !!criteria.lastName || !!criteria.dateOfBirth || !!criteria.dateOfDeath || !!criteria.fromDate || !!criteria.toDate;
  },

  translateRace(race) {
    // Translate me
    return race;
  },

  translateGender(gender) {
    var genderTranslated = 'Unknown';
    switch (gender) {
      case 'male': genderTranslated = 'Male'; break;
      case 'female': genderTranslated = 'Female'; break;
    }

    return genderTranslated;
  }
});

/**
 * Interface action hooks.
 */
Store.dispatchToken = Dispatcher.register(function(action) {

  switch (action.type) {

    case Constants.LOAD:
      loadPatients();
    break;

    case Constants.RESET_CRITERIA:
      criteria = new CriteriaModel();
      loadPatients();
    break;

    case Constants.SELECT:
      var index = findIndex(action.id);
      if (index === -1) throw 'Patient not found.';

      if (currentPatientId !== null && currentPatientId !== -1) {
        deselectById(currentPatientId);
      }

      selectById(action.id);
      currentPatientId = action.id;
      Store.emitCurrentPatientChange(); // Don't think this should happen?!
    break;

    case Constants.SET_SORT_KEY:
      sortKey = action.key;
      sortDirection = action.direction;
      loadPatients();
    break;

    case Constants.SET_CRITERIA:
      criteria = new CriteriaModel(action.criteria);
      loadPatients();
    break;

    case Constants.SET_CRITERIA_BY_KEY:
      criteria = criteria.set(action.key, action.value);
      loadPatients();
    break;

    default:
      // Do nothing
  }

});

/**
 * Convenience functions.
 */
function _dir(reverse) {
  return reverse ? ('desc' == sortDirection ? 1 : -1) : ('desc' == sortDirection ? -1 : 1);
}

function loadPatients() {
  API.cancel().getJSON(createIndexURL()).then(function(response) {
    // Clear patients list prior to loading new patients.
    patients = patients.clear();

    // Inject all patients into list.
    response._embedded.items.forEach(function(patient) {
      patients = patients.push(new PatientModel(patient));
    });

    // Unset current patient if it's no longer in the list.
    if (!has(currentPatientId)) {
      currentPatientId = null;
      Store.emitCurrentPatientChange();
    }

    Store.emitChange();
  });
}

function createShowURL(id) {
  return Routing.generate('accard_frontend_patient_show', { id: id });
}

function createNewURL() {
  return Routing.generate('accard_frontend_patient_create');
}

function createIndexURL() {
  var params = {
    criteria: {},
    sorting: {},
    page: page || 1,
    limit: limit || 25
  };

  if (criteria.mrn) {
    params.criteria.mrn = criteria.get('mrn');
  }

  if (criteria.firstName) {
    params.criteria.firstName = criteria.get('firstName');
  }

  if (criteria.lastName) {
    params.criteria.lastName = criteria.get('lastName');
  }

  if (criteria.fromDate) {
    params.criteria.fromDate = criteria.get('fromDate');
  }

  if (criteria.toDate) {
    params.criteria.toDate = criteria.get('toDate');
  }

  params.sorting[sortKey] = sortDirection;

  return Routing.generate('accard_api_patient_index', params);
}

function find(patientId) {
  return patients.find(function(patient) {
    return patient.id === patientId;
  });
}

function findIndex(patientId) {
  return patients.findIndex(function(patient) {
    return patient.id === patientId;
  });
}

function has(patientId) {
  return !!patients.find(function(patient) {
    return patient.id === patientId;
  });
}

function selectById(patientId) {
  var patient = find(patientId);
  var index = findIndex(patientId);
  if (!patient) return;
  patients = patients.set(index, patient.set('selected', true));
}

function deselectById(patientId) {
  var patient = find(patientId);
  var index = findIndex(patientId);
  if (!patient) return;
  patients = patients.set(index, patient.set('selected', false));
}

/**
 * We need to preload some data, not sure if we should do this here...
 */
require('./actions').load();

module.exports = Store;
