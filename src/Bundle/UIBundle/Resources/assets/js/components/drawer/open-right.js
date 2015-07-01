'use strict';

var React = require('react');
var Open = require('./open');

var OpenRight = React.createClass({
  propTypes: {
    handleClick: React.PropTypes.func
  },
  render: function() {
    return <Open direction='right' handleClick={this.props.handleClick} />;
  }
});

module.exports = OpenRight;
