'use strict';

var React = require('react');
var Open = require('./open');

var OpenLeft = React.createClass({
  propTypes: {
    handleClick: React.PropTypes.func
  },
  render: function() {
    return <Open direction='left' handleClick={this.props.handleClick} />;
  }
});

module.exports = OpenLeft;
