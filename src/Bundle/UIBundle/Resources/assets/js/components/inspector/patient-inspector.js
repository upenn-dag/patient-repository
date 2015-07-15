'use strict';

var React = require('react/addons');
var Bootstrap = require('react-bootstrap');
var PatientStore = require('./../../stores/patient/store');
var State = require('./../../state').get();
var ObjLink = require('./patient-inspector-link');
var ProtoLink = require('./patient-inspector-proto-link');

var links = [];

links.push(<ObjLink key='diagnosis' obj='diagnosis' label='Diagnosis' />);

State.getObjectPrototypes('activity').forEach(function(prototype, name) {
  links.push(
    <ProtoLink key={'activity-'+name} obj='activity' proto={name} label={prototype.get('presentation') + ' Activity'} />
  );
});

State.getObjectPrototypes('attribute').forEach(function(prototype, name) {
  links.push(
    <ProtoLink key={'attribute-'+name} obj='attribute' proto={name} label={prototype.get('presentation') + ' Attribute'} />
  );
});

State.getObjectPrototypes('behavior').forEach(function(prototype, name) {
  links.push(
    <ProtoLink key={'behavior-'+name} obj='behavior' proto={name} label={prototype.get('presentation') + ' Behavior'} />
  );
});

State.getObjectPrototypes('regimen').forEach(function(prototype, name) {
  links.push(
    <ProtoLink key={'regimen-'+name} obj='regimen' proto={name} label={prototype.get('presentation') + ' Regimen'} />
  );
});

State.getObjectPrototypes('sample').forEach(function(prototype, name) {
  links.push(
    <ProtoLink key={'sample-'+name} obj='sample' proto={name} label={prototype.get('presentation') + ' Sample'} />
  );
});

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
      str = (
        <div className='text-center'>
          <Bootstrap.SplitButton title='Create for active patient'>
            {links}
          </Bootstrap.SplitButton>
        </div>
      );
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
