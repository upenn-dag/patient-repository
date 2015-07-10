'use strict';

var React = require('react/addons');
// var Store = require('../../stores/outcomes/store');

var Outcomes = React.createClass({

  mixins: [React.addons.PureRenderMixin],

  propTypes: {
    accard: React.PropTypes.object.isRequired
  },

  render() {
    var Routing = require('./../../routing').Routing;
    var outcomesURL = Routing.generate('accard_outcomes_main');

    return (
      <div className='accard-main-wrapper col-sm-12'>
        <iframe src={outcomesURL} ref='iframe'></iframe>
      </div>
    );
  }
});

module.exports = Outcomes;
