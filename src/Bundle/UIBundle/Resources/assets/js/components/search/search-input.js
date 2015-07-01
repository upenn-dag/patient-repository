'use strict';

var React = require('react');
var Actions = require('./actions');

var ENTER_KEY_CODE = 13;

var SearchInput = React.createClass({

  getInitialState: function() {
    return { term: this.props.term ? this.props.term : '' };
  },

  handleKeyDown: function(e) {
    if (e.keyCode === ENTER_KEY_CODE) {
      e.preventDefault();
      var text = this.state.term.trim();
      if (text) {
        Actions.search(text);
      }
    }
  },

  handleChange: function(e) {
    this.setState({
      term: e.target.value
    });
  },

  render: function() {
    return <input type='text' className='form-control' placeholder='Search' ref='search' value={this.state.term} onKeyDown={this.handleKeyDown} onChange={this.handleChange} />;
  }
});

module.exports = SearchInput;
