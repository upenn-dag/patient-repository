'use strict';

var alert = window.alert;

var React = require('react/addons');
var Bootstrap = require('react-bootstrap');
var DrawerMixin = require('./drawer');
var AccardActions = require('./../../stores/accard/actions');

var LeftDrawer = React.createClass({

//  mixins: [React.addons.PureRenderMixin],

  render() {
    var outcomesTooltip = (<Bootstrap.Tooltip>Experimental developer preview</Bootstrap.Tooltip>);

    return (
      <ul className="sidebar-nav">
        <li className="sidebar-brand">
          <a href='#' onClick={this._handlePatientClick}>Patients</a>
        </li>
        <li className="divider"></li>
        <li><a href="#" onClick={this._handleNewPatientClick}>New Patient</a></li>
        <li>
          <Bootstrap.OverlayTrigger placement='right' overlay={outcomesTooltip}>
            <a href="#" onClick={this._handleOutcomesClick}>Outcomes</a>
          </Bootstrap.OverlayTrigger>
        </li>
        <li><a href="#" onClick={this.comingSoon}>Reports</a></li>
        <li><a href="#" onClick={this.comingSoon}>System Log</a></li>
        <li className="divider"></li>
        <li><a href="#" onClick={this._handleCreditsClick}>Credits</a></li>
      </ul>
    );
  },

  comingSoon(e) {
    if (e.preventDefault) e.preventDefault();
    alert('Coming soon! This feature has been planned for the near future, and will become available upon completion.');
  },

  _handleCreditsClick(e) {
    if (e.preventDefault) e.preventDefault();
    AccardActions.switchSubapplication('credits');
  },

  _handleOutcomesClick(e) {
    if (e.preventDefault) e.preventDefault();
    AccardActions.switchSubapplication('outcomes');
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
