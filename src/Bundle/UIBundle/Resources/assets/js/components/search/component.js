'use strict';

var React      = require('react');
var Accard = require('./../../accard');
var SearchInput = require('./search-input');
var Dispatcher = require('./dispatcher');
var Actions = require('./actions');
var Constants = require('./constants');
var HistoryStore = require('./history-store');
var Utils = require('./utils');

var ENTER_KEY_CODE = 13;

function getStateFromStore() {
  return {
    active: HistoryStore.getActive(),
    items: HistoryStore.getAll()
  };
}

/**
 * SEARCH COMPONENT
 * =================
 * The search component handles stateful searching within Accard. It
 * utilizes javascript local storage if it is available in order to
 * save the last search performed by the current browser user.
 *
 * TODO: Provide fallback storage for previous search
 * AUTHOR: Frank Bardon Jr. <bardonf@upenn.edu>
 */
var Search = React.createClass({

  propTypes: {
    accard: React.PropTypes.instanceOf(Accard)
  },

  getInitialState: function() {
    return getStateFromStore();
  },

  handleSubmit: function(e) {
    e.preventDefault();
  },

  render: function() {
    var term = this.state.active ? this.state.active.term : '';

    return (
      <form className='navbar-form navbar-search' role='search' onSubmit={this.handleSubmit}>
        <SearchInput term={term} />
        <span className='fa fa-search'></span>
      </form>
    );
  },

  componentDidMount: function() {
    HistoryStore.addChangeListener(this._onChange);
  },

  componentWillUnmount: function() {
    HistoryStore.removeChangeListener(this._onChange);
  },

  _onChange: function() {
    this.setState(getStateFromStore());
  }
});

/**
 * Constants
 */
Search.SEARCH = Constants.SEARCH;
Search.CLEAR = Constants.CLEAR;
Search.CLEAR_ALL = Constants.CLEAR_ALL;

module.exports = Search;
