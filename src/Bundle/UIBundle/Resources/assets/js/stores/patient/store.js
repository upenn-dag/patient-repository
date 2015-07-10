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
var DEFAULT_LIMIT = 25;
var cache = Immutable.Map();
var requestCache = {};
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

  hasMorePatientsToLoad() {
    return pages > page;
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
      page = 1;
      limit = DEFAULT_LIMIT;
      loadPatients(false);
    break;

    case Constants.LOAD_MORE:
      if (page >= pages) {
        page = pages;
      } else {
        page++;
        limit = LIMIT + DEFAULT_LIMIT;
        loadPatients(true);
      }
    break;

    case Constants.RESET_CRITERIA:
      page = 1;
      limit = DEFAULT_LIMIT;
      criteria = new CriteriaModel();
      loadPatients(false);
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
      page = 1;
      sortKey = action.key;
      sortDirection = action.direction;
      loadPatients();
    break;

    case Constants.SET_CRITERIA:
      page = 1;
      limit = DEFAULT_LIMIT;
      criteria = new CriteriaModel(action.criteria);
      loadPatients();
    break;

    case Constants.SET_CRITERIA_BY_KEY:
      page = 1;
      limit = DEFAULT_LIMIT;
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

function loadPatients(merge) {
  merge = !!merge || false;

  var url = createIndexURL();
  var requestedPatients = [];

  // Cached? Load that instead.
  if (requestCache[url]) {

    page = requestCache[url].page;
    pages = requestCache[url].pages;
    total = requestCache[url].total;
    requestCache[url].ids.forEach(function(patientId) {
      requestedPatients.push(cache.get(patientId));
    });

    patients = merge ? patients.concat(requestedPatients) : Immutable.List(requestedPatients);
    Store.emitChange();

    return;
  }

  API.cancel().getJSON(url).then(function(response) {
    var requestData = {ids: []};

    // Inject all patients into the cache if they don't exist.
    response._embedded.items.forEach(function(patient) {
// Commented this out, not sure if we want to reload patients as they come?
//      if (!cache.has(patient.id)) {
        cache = cache.set(patient.id, new PatientModel(patient));
//      }

      requestedPatients.push(cache.get(patient.id));        
      requestData.ids.push(patient.id);
    });

    page = requestData.page = response.page;
    pages = requestData.pages = response.pages;
    total =  requestData.total = response.total;
    patients = merge ? patients.concat(requestedPatients) : Immutable.List(requestedPatients);

    // Cache the patient ids from the response.
    requestCache[url] = requestData;

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
    limit: limit || DEFAULT_LIMIT
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

module.exports = Store;
