'use strict';

var React = require('react');
var Component = require('./component');
var LeftDrawer = require('./left');
var RightDrawer = require('./right');

var LEFT = 'left';
var RIGHT = 'right';

var Drawer = React.createClass({
  propTypes: {
    onHide: React.PropTypes.func.isRequired,
    side: React.PropTypes.oneOf([LEFT, RIGHT]).isRequired,
    children: React.PropTypes.element
  },

  getSide: function() {
    return this.props.side;
  },

  isLeft: function() {
    return LEFT === this.props.side;
  },

  isRight: function() {
    return RIGHT === this.props.side;
  },

  render: function() {
    var classString = "drawer drawer-" + this.props.side;

    return (
      <div className={classString}>
        { this.isLeft() ? (<LeftDrawer onHide={this.props.onHide} />) : (<RightDrawer onHide={this.props.onHide} />) }
      </div>
    );
  }
});

Drawer.LEFT = LEFT;
Drawer.RIGHT = RIGHT;

module.exports = Drawer;
