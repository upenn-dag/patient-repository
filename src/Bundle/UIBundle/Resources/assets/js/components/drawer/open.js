'use strict';

var React = require('react');
var Drawer = require('./drawer');

function invert(direction) {
  if (Drawer.LEFT === direction) {
    return Drawer.RIGHT;
  }

  return Drawer.LEFT;
}

var Open = React.createClass({
  propTypes: {
    direction: React.PropTypes.oneOf([Drawer.LEFT, Drawer.RIGHT]).isRequired,
    handleClick: React.PropTypes.func
  },

  render: function() {
    return(
      <a href='#' className={'drawer-handle drawer-open-' + this.props.direction} ref={this.props.direction} onClick={this.props.handleClick}>
        <span className={'fa fa-chevron-'+invert(this.props.direction)}></span>
      </a>
    );
  }
});

module.exports = Open;
