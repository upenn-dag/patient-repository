'use strict';

var React = require('react');
var Bootstrap = require('react-bootstrap');
var FramedModal = require('./framed');

var FramedModalButton = React.createClass({

  mixins: [Bootstrap.OverlayMixin],

  propTypes: {
    frameSource: React.PropTypes.string.isRequired
  },

  getInitialState() {
    return {
      isModalOpen: false
    };
  },

  getDefaultProps() {
    return {
      label: 'Launch Modal'
    }
  },

  handleToggle() {
    this.setState({
      isModalOpen: !this.state.isModalOpen
    });
  },

  render() {
    return (
      <Bootstrap.Button {...this.props} onClick={this.handleToggle}>
        {this.props.label}
      </Bootstrap.Button>
    );
  },

  renderOverlay() {
    return this.state.isModalOpen
      ? <FramedModal
          onRequestHide={this.handleToggle}
          source={this.props.frameSource}
          animation={false} />
      : <span />;
  },

  shouldComponentUpdate() {
    // TODO: Validate that source is valid URL.
    return !!this.props.frameSource;
  }
});

module.exports = FramedModalButton;
