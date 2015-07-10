'use strict';

var $ = require('jquery');
var React = require('react/addons');
var AccardStore = require('./stores/accard/store');
var AccardActions = require('./stores/accard/actions');
var alert = window.alert;
var console = window.console;

var defaults = {
  subApp: 'patients',
  drawers: {
    left: { initialize: true },
    right: { initialize: true }
  },
  inspector: { initialize: false },
  grid: { initialize: false },
  routes: {},
  state: {},
  debug: true
};

var AccardApplication = function() {
  this.initialized = false;
  this.contentElement = document.getElementById('accard-content');
  this.contentAreaElement = document.getElementById('accard-content-area');
  this.brand = null;
  this.brandElement = document.getElementById('accard-brand');
  this.drawers = null;
  this.drawerElement = document.getElementById('accard-drawers');
  this.inspector = null;
  this.inspectorElement = null; // Secondhand init: document.getElementById('accard-inspector');
  this.router = null;
  //this.search = null;
  //this.searchElement = document.getElementById('accard-search');
  this.grid = null;
  this.gridElement = null; // Secondhand init: document.getElementById('accard-grid');
  this.tray = null;
  this.trayElement = document.getElementById('accard-tray-area');
  this.layout = null;
  this.modalElement = document.getElementById('accard-modal');
  this.modal = null;

  this.messagingServer = null;

  return this;
};

AccardApplication.prototype = {

  isValid: function(config) {
    // TODO: Add config validation.
    return true;
  },

  initialize: function(options) {
    if (!this.initialized) {
      this.options = $.extend(true, defaults, options || {});

      this.initializeRouting();
      this.initializeContent();
      this.initializeBrand();
      //this.initializeSearch();
      this.initializeDrawers();
      this.initializeTray();

      this.initializeSubapplications();

      this.initialized = true;

      this._debug('Initialized accard application.');
    }

    return this;
  },

  initMessaging: function() {
    if (null === this.messagingServer) {
      var messaging = require('./messaging');
      var Client = messaging.Client;
      this.messagingServer = messaging.mainServer;
      this.messagingClient = new Client();
    }
  },

  getMessagingServer: function() {
    this.initMessaging();
    return this.messagingServer;
  },

  getMessagingClient: function() {
    this.initMessaging();
    return this.messagingClient;
  },

  isInitialized: function() {
    return this.initialized;
  },

  isDebug: function() {
    return this.options.debug || false;
  },

  selectPatient: function(patientId) {
    this.grid.setSelectedPatient(patientId);
    return this._debug('Selected patient ' + patientId);
  },

  activatePatient: function(patientId) {
    this.selectPatient(patientId);
  },

  initializeSubapplications: function() {
    AccardStore.addChangeListener(this._onSwitchSubapplication.bind(this));
    return this._debug('Initialized subapplications');
  },

  _onSwitchSubapplication: function() {
    this._navigate(AccardStore.getSubapplication());
  },

  // TODO: Move this into event handler...
  _navigate: function(subApplication) {
    this._debug('Navigating to ' + subApplication);

    if (this.inspectorElement) React.unmountComponentAtNode(this.inspectorElement);
    if (this.gridElement) React.unmountComponentAtNode(this.gridElement);
    React.unmountComponentAtNode(this.contentElement);

    switch (subApplication) {
      case 'patients':
        var PatientsSubapp = require('./components/subapp/patients-subapp');
        React.render(<PatientsSubapp accard={this} />, this.contentElement);
        this.initializeGrid();
        this.initializeInspector();
      break;

      case 'patient':
        var PatientSubapp = require('./components/subapp/patient-subapp');
        React.render(<PatientSubapp accard={this} />, this.contentElement);
      break;

      case 'newPatient':
        var NewPatientSubapp = require('./components/subapp/new-patient-subapp');
        React.render(<NewPatientSubapp accard={this} />, this.contentElement);
      break;

      case 'credits':
        var CreditsSubapp = require('./components/subapp/credits-subapp');
        React.render(<CreditsSubapp accard={this} />, this.contentElement);
      break;

      default:
        throw 'Subapplication not found.';
    }
  },

  initializeContent: function(subApplication) {
    this._navigate('patients');
  },

  initializeTray: function() {
    if (this.trayElement) {
      var Tray = require('./components/tray/component');
      this.tray = React.render(<Tray />, this.trayElement);

      this._debug('Initialized tray', this.tray);
    }
  },

  closeTray: function() {
    this.tray.close();
    this._debug('Closed tray');
    return this;
  },

  isTrayClosed: function() {
    return this.tray.isClosed();
  },

  isTrayOpen: function() {
    return this.tray.isOpen();
  },

  openTray: function(trayKey) {
    this.tray.select(trayKey);
    this._debug('Opened tray', this.tray);
    return this;
  },

  initializeGrid: function() {
    this.gridElement = document.getElementById('accard-grid');
    if (this.gridElement) {
      var PatientGrid = require('./components/patient-grid/component');
      this.grid = React.render(<PatientGrid height={this.gridElement.clientHeight} width={this.gridElement.clientWidth} onRowClick={this._handleGridRowClick.bind(this)} onRowDoubleClick={this._handleGridRowDoubleClick.bind(this)} />, this.gridElement);
      this._debug('Initialized grid', this.grid);
    } else {
      this._debug('No grid element found');
    }

    return this;
  },

  setGridSort: function(key, direction) {
    direction = direction || 'desc';
    this.grid.setSortKey(key, direction);
    this._debug('Grid sorting set to ' + key + ', ' + direction);
    return this;
  },

  _handleGridRowClick: function(e, rowId, patient) {
    return this.selectPatient(patient.id);
  },

  _handleGridRowDoubleClick: function(e, rowId, patient) {
    AccardActions.switchSubapplication('patient');
  },

  initializeBrand: function() {
    if (this.brandElement) {
      var Brand = require('./components/brand/component');
      this.brand = React.render(<Brand tooltip={this._handleBrandTooltip.bind(this)} onClick={this._handleBrandClick.bind(this)} />, this.brandElement);
      this._debug('Brand initialized', this.brand);
    }

    return this;
  },

  _handleBrandTooltip: function(subApplication) {
    var retVal = false;
    switch (subApplication) {
      case 'patient':
        retVal = 'Back to grid';
      break;
      case 'newPatient':
        retVal = 'Back to grid';
      break;
    }

    return retVal;
  },

  _handleBrandClick: function(e) {
    AccardActions.switchSubapplication('patients');
  },

  hasBrand: function() {
    return !!this.brand;
  },

  initializeDrawers: function(left, right) {
    left = left || this.options.drawers.left.initialize;
    right = right || this.options.drawers.right.initialize;

    if (!left && !right) {
      this._debug('Drawers skipped, both sides are hidden');
      return;
    }

    if (this.drawerElement && this.contentAreaElement) {
      var Drawers = require('./components/drawer/component');
      this.drawers = React.render(<Drawers element={this.contentAreaElement} left={left} right={right} />, this.drawerElement); 
      this._debug('Drawers initialized left: ' + left.toString() + ' right:' + right.toString(), this.drawers);
    }

    return this;
  },

  closeDrawer: function() {
    if (this.drawers) this.drawers.close();
    this._debug('Drawer closed');
    return this;
  },

  hasLeftDrawer: function() {
    return !!this.drawers && this.drawers.hasLeft();
  },

  openLeftDrawer: function() {
    if (this.drawers) this.drawers.openLeft();
    this._debug('Left drawer opened (attempt)');
    return this;
  },

  hasRightDrawer: function() {
    return !!this.drawers && this.drawers.hasRight();
  },

  openRightDrawer: function() {
    if (this.drawers) this.drawers.openRight();
    this._debug('Right drawer opened (attempt)');
    return this;
  },

  initializeInspector: function() {
    this.inspectorElement = document.getElementById('accard-inspector');

    if (this.inspectorElement) {
      var Inspector = require('./components/inspector/component');
      this.inspector = React.render(<Inspector />, this.inspectorElement);
      this._debug('Inspector initialized', this.inspector);
    } else {
      this._debug('No inspector element found.');
    }

    return this;
  },

  initializeRouting: function() {
    // Add environment detection...
    var Routing = require('./routing');
    Routing.Router.setData(this.options.routes);
    this.router = Routing.Routing;
    this._debug('Router initialized with data', this.router, this.options.routes);
  },

  openModal: function(source) {
    if (this.modal) this.closeModal();
    var FramedModal = require('./components/modal/framed');
    this.modal = React.render(<FramedModal source={source} />, this.modalElement);
  },

  closeModal: function() {
    React.unmountComponentAtNode(this.modalElement);
    this.modal = null;
  },

  _debug: function(message) {
    if (this.isDebug()) {
      console.log(message, arguments);
    }

    return this;
  }

};

module.exports = AccardApplication;


  /*
   * Temporarily removed, must remain for later development.
   * Add back into the accard application object.
   *
  initializeSearch: function() {
    if (this.searchElement) {
      var Search = require('./components/search/component');
      var SearchDispatcher = require('./components/search/dispatcher');

      SearchDispatcher.register(function(action) {
        if (Search.SEARCH === action.type) {
          alert('Performing the search for: "' + action.term + '"');
        }
      });

      this.search = React.render(<Search />, this.searchElement);

      this._debug('Search initialized', this.search);
    } else {
      this._debug('No search element found');
    }

    return this;
  },

  hasSearch: function() {
    return !!this.search;
  },
  */
