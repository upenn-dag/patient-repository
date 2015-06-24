'use strict';

var React = require('react');
var Bootstrap = require('react-bootstrap');

var FramedModal = React.createClass({

  propTypes: {
    source: React.PropTypes.string.isRequired,
    onRequestHide: React.PropTypes.func
  },

  getDefaultProps() {
    return {
      title: false
    };
  },

  render() {
    return (
      <div className="accard-input-modal" ref="top">
        <Bootstrap.Modal
          {...this.props}>
          <div className='iframe-buttons'>
            <button type='button' className='refresher' onClick={this.refresh}>
              <span className='fa fa-refresh'></span>
            </button>
            <button type='button' className='closer' onClick={this.hide}>
              <span className='fa fa-close'></span>
            </button>
          </div>
          <div className='modal-body'>
            <iframe src={this.props.source} ref='iframe' style={{ border: 'none' }} />
          </div>
        </Bootstrap.Modal>
      </div>
    );
  },

  hide() {
    if (this.props.onRequestHide) this.props.onRequestHide();
  },

  refresh() {
    React.findDOMNode(this.refs.iframe).contentWindow.location.reload();
  },

  shouldComponentUpdate(nextProps, nextState) {
    return !!this.props.source || this.props.source == nextProps.source;
  }
});

module.exports = FramedModal;
