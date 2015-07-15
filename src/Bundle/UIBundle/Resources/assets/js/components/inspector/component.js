'use strict';

var React = require('react');
var PatientFilter = require('./patient-filter');
var PatientInspector = require('./patient-inspector');
var AccardActions = require('./../../stores/accard/actions');

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
            <div className='pull-right'>
              <a href='#' onClick={this.create}>
                create
              </a>
            </div>
            <div className='inspector-title'>Patient</div>
          </div>
          <div className='inspector-body' ref='body'>
            <PatientInspector />
          </div>
        </div>
      </div>
    );
  },

  create(e) {
    if (e && e.preventDefault) e.preventDefault();
    AccardActions.switchSubapplication('newPatient');
  }
});

module.exports = InspectorComponent;
