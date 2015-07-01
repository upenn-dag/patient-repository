'use strict';

var React = require('react');
var Bootstrap = require('react-bootstrap');

var TrayCloseButton = React.createClass({
  render() {
    return (
      <Bootstrap.Button {...this.props} bsStyle='link' rel='close'>
        <span className='fa-stack fa-lg'>
          <span className='fa fa-circle fa-stack-2x'></span>
          <span className='fa fa-times fa-stack-1x fa-inverse'></span>
        </span>
      </Bootstrap.Button>
    );
  }
});

module.exports = TrayCloseButton;
