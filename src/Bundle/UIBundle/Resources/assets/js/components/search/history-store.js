'use strict';

var Constants = require('./constants');
var Dispatcher = require('./dispatcher');
var Utils = require('./utils');
var EventEmitter = require('events').EventEmitter;
var assign = require('object-assign');

var MAX_ITEMS = 25;
var CHANGE_EVENT = 'search-history-change';
var _items = {};
var _activeItem = null;

function pruneItems() {
  var size = 0, key;
  for (key in _items) {
    if (_items.hasOwnProperty(key)) size++;
    if (size > MAX_ITEMS) delete _items[key];
  }
}

var HistoryStore = assign({}, EventEmitter.prototype, {
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
    return _items[id];
  },

  getActive: function() {
    return _activeItem;
  },

  getAll: function() {
    return _items;
  },

  hasActive: function() {
    return !!_activeItem;
  }
});

/**
 * Interface action hooks.
 */
HistoryStore.dispatchToken = Dispatcher.register(function(action) {

  switch (action.type) {

    case Constants.SEARCH:
      var item = Utils.createSearchObject(action.term);
      _items[item.id] = item;
      _activeItem = item;
      pruneItems();
      HistoryStore.emitChange();
    break;

    case Constants.CLEAR:
      _activeItem = null;
      HistoryStore.emitChange();
    break;

    case Constants.CLEAR_ALL:
      _items.length = 0;
      _activeItem = null;
      HistoryStore.emitChange();
    break;

    default:
      // Do nothing
  }

});

/**
 * Local storage enable.
 */
var COMPAT = !!window.JSON && !!window.localStorage;
var SEARCH_KEY = 'accard-search-history';
var EMPTY_ID = 0;

function getItemsFromLocalStore() {
  var storeData = window.localStorage.getItem(SEARCH_KEY);

  if (storeData) {
    return JSON.parse(storeData);
  }

  // Return an empty store.
  return { active: EMPTY_ID, items: {} };
}

function saveItemsToLocalStore() {
  var data = {
    activeId: _activeItem ? _activeItem.id : EMPTY_ID,
    items: HistoryStore.getAll()
  };

  window.localStorage.setItem(SEARCH_KEY, JSON.stringify(data));
}

/**
 * None of these callbacks are change emitters, as they
 * do not attempt to change anything.
 */
function localStoreExtension(action) {

  switch (action.type) {
    case Constants.SEARCH:
      saveItemsToLocalStore();
    break;

    case Constants.CLEAR:
      window.localStorage.removeItem(SEARCH_KEY);
    break;

    case Constants.CLEAR_ALL:
      window.localStorage.removeItem(SEARCH_KEY);
    break;
  }
}

if (COMPAT) {
  Dispatcher.register(localStoreExtension);

  // Load up local storage data into our store.
  var storeData = getItemsFromLocalStore();

  // Loop in items from store.
  var key;
  for (key in storeData.items) {
    if (!storeData.items.hasOwnProperty(key)) continue;
    _items[storeData.items[key].id] = storeData.items[key];
  }

  // If the active is empty, don't set it.
  if (EMPTY_ID != storeData.active) {
    _activeItem = _items[storeData.activeId.toString()];
  }
}

module.exports = HistoryStore;
