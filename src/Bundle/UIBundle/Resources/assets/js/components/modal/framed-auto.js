'use strict';

var React = require('react');
var Bootstrap = require('react-bootstrap');
var FramedModal = require('./framed');

var FramedModalButton = React.createClass({

  mixins: [Bootstrap.OverlayMixin],

  propTypes: {
    frameSource: React.PropTypes.string.isRequired,
    onHide: React.PropTypes.string
  },

  getInitialState() {
    return {
      isModalOpen: true
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

    if (this.props.onHide) {
      switch (this.props.onHide) {
        case 'reload':
          // Do something with reload...
        break;
      }
    }
  },

  render() {
    return null;
  },

  renderOverlay() {
    return this.state.isModalOpen
      ? <FramedModal
          {...this.props}
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
