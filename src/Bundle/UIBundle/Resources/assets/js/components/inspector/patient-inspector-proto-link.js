'use strict';

/**
 * @todo We need to remove the reliance on window.accard being available...
 */

var React = require('react/addons');
var Bootstrap = require('react-bootstrap');
var PatientStore = require('./../../stores/patient/store');
var State = require('./../../state').get();
var Router = require('./../../routing').Routing;

var PatientInspectorProtoLink = React.createClass({

  mixins: [React.addons.PureRenderMixin],

  propTypes: {
    obj: React.PropTypes.string.isRequired,
    proto: React.PropTypes.string.isRequired,
    label: React.PropTypes.string.isRequired
  },

  getInitialState() {
    return {
      patient: PatientStore.getCurrentPatient()
    };
  },

  render() {
    return <Bootstrap.MenuItem onSelect={this.open}>{this.props.label}</Bootstrap.MenuItem>
  },

  open(e) {
    if (!window.accard) throw 'Accard instance must be attached to the window';

    var url = Router.generate(
      'accard_frontend_'+this.props.obj+'_create',
      {
        patient: this.state.patient.id,
        prototype: this.props.proto
      }
    );

    window.accard.openModal(url);
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

module.exports = PatientInspectorProtoLink;
