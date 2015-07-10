'use strict';

var React = require('react');
var Bootstrap = require('react-bootstrap');

var FramedModal = React.createClass({

  propTypes: {
    source: React.PropTypes.string.isRequired,
    onHide: React.PropTypes.func
  },

  getInitialState() {
    return { show: true };
  },

  render() {
    return (
      <div className="accard-input-modal" ref="top">
        <Bootstrap.Modal
          {...this.props}
          show={this.state.show}
          onHide={this.hide}
          container={this}>
          <div className='iframe-buttons'>
            <button type='button' className='refresher' onClick={this.refresh}>
              <span className='fa fa-refresh'></span>
            </button>
            <button type='button' className='closer' onClick={this.hide}>
              <span className='fa fa-close'></span>
            </button>
          </div>
          <Bootstrap.Modal.Body>
            <iframe src={this.props.source} ref='iframe' style={{ border: 'none' }} />
          </Bootstrap.Modal.Body>
        </Bootstrap.Modal>
      </div>
    );
  },

  hide() {
    this.setState({ show: false });
  },

  refresh() {
    React.findDOMNode(this.refs.iframe).contentWindow.location.reload();
  },

  shouldComponentUpdate(nextProps, nextState) {
    return !!this.props.source || this.props.source == nextProps.source;
  }
});

module.exports = FramedModal;
