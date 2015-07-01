'use strict';

var React = require('react');

var Inspector = React.createClass({

  propTypes: {
    title: React.PropTypes.string.isRequired
  },

  render() {
    return (
      <div className='inspector panel'>
        <div className='inspector-header'>
          <div className='inspector-title'>
            {this.props.title}
          </div>
        </div>
        <div className='inspector-body' ref='body'>
          {this.props.children}
        </div>
      </div>
    );
  }
});

module.exports = Inspector;
