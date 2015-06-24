'use strict';

var React = require('react');
var Drawer = require('./drawer');
var OpenLeft = require('./open-left');
var OpenRight = require('./open-right');
var VendorDrawer = require('./../../vendor/drawer');

var Drawers = React.createClass({

  propTypes: {
    element: React.PropTypes.object.isRequired,
    left: React.PropTypes.bool,
    right: React.PropTypes.bool,
    handles: React.PropTypes.bool,
  },

  getDefaultProps: function() {
    return {
      left: false,
      right: false,
      handles: true
    };
  },

  // Invoke drawer dependency...
  // TODO: Separate left and right widths allowing different sizes on either side.
  componentDidMount: function() {
    var leftWidth = this._calculateWidth(this.refs.left);
    var rightWidth = this._calculateWidth(this.refs.right);
    var totalWidth = leftWidth > rightWidth ? leftWidth : rightWidth;

    // Initialize via jQuery
    this.drawer = new VendorDrawer({
      element: this.props.element,
      maxPosition: totalWidth, // Make dynamic...
      minPosition: (totalWidth*-1), // Make dynamic...
    });

    this.drawer.disable(); // Disable dragging, for now.
  },

  render: function () {
    var handles = [];

    if (this.props.handles) {
      if (this.hasLeft()) {
        handles.push(<OpenLeft key={Drawer.LEFT} handleClick={this._handleClickLeft} />);
      }
      if (this.hasRight()) {
        handles.push(<OpenRight key={Drawer.RIGHT} handleClick={this._handleClickRight} />);
      }
    }

    return (
      <div className="drawers">
        { handles }
        { this.props.left ? (<Drawer side={Drawer.LEFT} ref={Drawer.LEFT} />) : null }
        { this.props.right ? (<Drawer side={Drawer.RIGHT} ref={Drawer.RIGHT} />) : null }
      </div>
    );
  },

  // TODO: Check cross platform.
  _calculateWidth: function(element) {
    return element ? React.findDOMNode(element).offsetWidth : 0;
  },

  _handleClickLeft: function(e) {
    if (Drawer.LEFT === this.drawer.state().state) {
      this.close();
    } else {
      this.openLeft();
    }
  },

  _handleClickRight: function(e) {
    if (Drawer.RIGHT === this.drawer.state().state) {
      this.close();
    } else {
      this.openRight();
    }
  },

  close: function() {
    this.drawer.close();
  },

  openLeft: function() {
    if (this.hasLeft()) this.drawer.open(Drawer.LEFT);
  },

  openRight: function() {
    if(this.hasRight()) this.drawer.open(Drawer.RIGHT);
  },

  hasBoth: function() {
    return this.hasLeft() && this.hasRight();
  },

  hasLeft: function() {
    return this.props.left;
  },

  hasRight: function() {
    return this.props.right;
  }

});

module.exports = Drawers;
