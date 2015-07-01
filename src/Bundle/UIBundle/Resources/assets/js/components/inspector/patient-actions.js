'use strict';

var React = require('react');
var Bootstrap = require('react-bootstrap');
var AccardActions = require('./../../stores/accard/actions');

var PatientActions = React.createClass({
  render() {
    return (
      <div className="patient-actions-inspector">
        <Bootstrap.Button bsStyle='primary' bsSize='xsmall' block onClick={this._handleNew}>New patient</Bootstrap.Button>
      </div>
    );
  },

  _handleNew(e) {
    if (e.preventDefault) e.preventDefault();
    AccardActions.switchSubapplication('newPatient');
  }
});

module.exports = PatientActions;
