'use strict';

var React = require('react');
var PatientFilter = require('./patient-filter');
var PatientInspector = require('./patient-inspector');

/*
var PatientActions = require('./patient-actions');

        <div className='inspector panel'>
          <div className='inspector-header'>
            <div className='inspector-title'>Patients</div>
          </div>
          <div className='inspector-body' ref='body'>
            <PatientActions />
          </div>
        </div>
*/

var InspectorComponent = React.createClass({

  render() {
    return (
      <div className='inspectors'>
        <div className='inspector panel'>
          <div className='inspector-header'>
            <div className='inspector-title'>Filters</div>
          </div>
          <div className='inspector-body' ref='body'>
            <PatientFilter />
          </div>
        </div>

        <div className='inspector panel'>
          <div className='inspector-header'>
            <div className='inspector-title'>Selected Patient</div>
          </div>
          <div className='inspector-body' ref='body'>
            <PatientInspector />
          </div>
        </div>
      </div>
    );
  },

  add() {}
});

module.exports = InspectorComponent;
