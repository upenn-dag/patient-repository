'use strict';

var React = require('react/addons');
var FramedModalButton = require('../modal/framed-button');
var PatientStore = require('./../../stores/patient/store');

var PatientInspector = React.createClass({

  mixins: [React.addons.PureRenderMixin],

  getInitialState() {
    return {
      patient: PatientStore.getCurrentPatient()
    };
  },

  render() {
    var str;
    if (!this.state.patient) {
      str = <p>Please select a patient.</p>;
    } else {
      str = <p>Render out the patient {this.state.patient.id} inspector</p>;
    }

    return (
      <div className="patients-inspector">
        {str}
      </div>
    );
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

module.exports = PatientInspector;
