'use strict';

var React = require('react');
var LeftDrawer = require('./left');
var RightDrawer = require('./right');

var LEFT = 'left';
var RIGHT = 'right';

var Drawer = React.createClass({
  propTypes: {
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
        { this.isLeft() ? (<LeftDrawer />) : (<RightDrawer />) }
      </div>
    );
  }
});

Drawer.LEFT = LEFT;
Drawer.RIGHT = RIGHT;

/* EXAMPLE DRAWER UTILITY!

Drawer.doSomething = function() { return 'hey!'; };

*/

module.exports = Drawer;
