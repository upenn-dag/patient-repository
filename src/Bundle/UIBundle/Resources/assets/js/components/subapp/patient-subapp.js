'use strict';

var React = require('react/addons');
var PatientStore = require('./../../stores/patient/store');
var AccardActions = require('./../../stores/accard/actions');

var PatientSubapp = React.createClass({

  mixins: [React.addons.PureRenderMixin],

  propTypes: {
    accard: React.PropTypes.object.isRequired
  },

  getInitialState() {
    return {
      patient: PatientStore.getCurrentPatient()
    }
  },

  render() {
    if (!this.state.patient) {
      return (
        <div className='accard-main-wrapper col-sm-12'>
          No patient has been selected, please try again.
        </div>
      );
    }

    var iframeSource = PatientStore.createShowURL(this.state.patient.id);

    return (
      <div className='accard-main-wrapper col-sm-12'>
        <div className='iframe-buttons'>
          <button type='button' className='refresher' onClick={this.refresh}>
            <span className='fa fa-refresh'></span>
          </button>
          <button type='button' className='closer' onClick={this.hide}>
            <span className='fa fa-close'></span>
          </button>
        </div>
        <iframe src={iframeSource} ref='iframe' onLoad={this._handleIframeLoad}></iframe>
      </div>
    );
  },

  hide() {
    AccardActions.switchSubapplication('patients');
  },

  refresh() {
    React.findDOMNode(this.refs.iframe).contentWindow.location.reload();
  },

  _handleIframeLoad(e) {
    if (!e.target || !e.target.contentWindow) {
      throw "Unable to locate iframe content window.";
    }

    var iframeWindow = e.target.contentWindow;
    var messagingClient = this.props.accard.getMessagingClient();

    iframeWindow.accardClient = messagingClient;
  },

  componentDidMount() {
    PatientStore.addCurrentPatientListener(this._onChange);
  },

  componentWillUnmount() {
    PatientStore.removeCurrentPatientListener(this._onChange);
  },

  _onChange() {
    this.setState({
      patient: PatientStore.getCurrentPatient()
    });
  }
});

module.exports = PatientSubapp;
