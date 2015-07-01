'use strict';

var React = require('react');
var Bootstrap = require('react-bootstrap');
var CloseButton = require('./close-button');

function createStateFromKey(key) {
    return { key: (key ? key : false), closable: (key ? true : false) };
}

var Tray = React.createClass({

  getInitialState() {
    return createStateFromKey(false);
  },

  close() {
    this.setState(createStateFromKey(false));
  },

  get() {
    return this.state.key;
  },

  isClosed() {
    return !this.isOpen();
  },

  isOpen() {
    return !!this.get();
  },

  select(key) {
    this.setState(createStateFromKey(key));
  },

  render() {
    var closeButton = this.state.closable ? <CloseButton onClick={this.close} /> : null;
    var wrapperClass = this.state.closable ? 'tray-opened' : 'tray-closed';

    var alertInstance = (
      <Bootstrap.Alert bsStyle='info'>
        <strong>Coming soon!</strong>
        This feature has been planned for the near future, and will become available upon completion.
      </Bootstrap.Alert>
    );

    return (
      <div className={wrapperClass}>
        {closeButton}
        <div id="accard-tray-wrapper">
          <Bootstrap.TabbedArea className="nav-tray" activeKey={this.state.key} onSelect={this.select} animation={false}>
            <Bootstrap.TabPane eventKey='help' tab='Help'>{alertInstance}</Bootstrap.TabPane>
            <Bootstrap.TabPane eventKey='notes' tab='Notes'>{alertInstance}</Bootstrap.TabPane>
            <Bootstrap.TabPane eventKey='status' tab='Status'>{alertInstance}</Bootstrap.TabPane>
            <Bootstrap.TabPane eventKey='tickets' tab='Tickets'>{alertInstance}</Bootstrap.TabPane>
          </Bootstrap.TabbedArea>
        </div>
      </div>
    );
  }

});

module.exports = Tray;
