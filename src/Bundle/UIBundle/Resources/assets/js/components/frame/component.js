'use strict';

var React = require('react');

var Frame = React.createClass({
  render() {
    return <iframe style={{ border: 'none' }} />;
  },

  renderFrame() {
    React.render(<div>{this.props.children}</div>, this.getDOMNode().contentDocument.body);
  },

  componentDidMount() {
    this.renderFrame();
  },

  componentDidUpdate() {
    this.renderFrame();
  },

  componentWillUnmount() {
    React.unmountAtNode(this.getDOMNode().contentDocument.body);
  }
});

module.exports = Frame;
