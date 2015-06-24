'use strict';

var React = require('react/addons');
var DrawerMixin = require('./drawer');
var AccardActions = require('./../../stores/accard/actions');

var LeftDrawer = React.createClass({

//  mixins: [React.addons.PureRenderMixin],

  render() {
    return (
      <ul className="sidebar-nav">
        <li className="sidebar-brand">
          <a href='#' onClick={this._handlePatientClick}>Patients</a>
        </li>
        <li className="divider"></li>
        <li><a href="#" onClick={this._handleNewPatientClick}>New Patient</a></li>
        <li><a href="#">Outcomes</a></li>
        <li><a href="#">Reports</a></li>
        <li><a href="#">System Log</a></li>
        <li className="divider"></li>
        <li><a href="#">Credits</a></li>
      </ul>
    );
  },

  _handlePatientClick(e) {
    if (e.preventDefault) e.preventDefault();
    AccardActions.switchSubapplication('patients');
  },

  _handleNewPatientClick(e) {
    if (e.preventDefault) e.preventDefault();
    AccardActions.switchSubapplication('newPatient');
  }
});

module.exports = LeftDrawer;
