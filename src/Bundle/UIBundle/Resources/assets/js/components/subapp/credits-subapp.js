'use strict';

var React = require('react/addons');

var CreditsSubapp = React.createClass({

  mixins: [React.addons.PureRenderMixin],

  propTypes: {
    accard: React.PropTypes.object.isRequired
  },

  getActualSource() {
    return this.refs.iframe.src;
  },

  render() {
    var Routing = require('./../../routing').Routing;
    var creditsURL = Routing.generate('accard_frontend_credits');

    return (
      <div className='accard-main-wrapper col-sm-12'>
        <iframe src={creditsURL} ref='iframe'></iframe>
      </div>
    );
  }
});

module.exports = CreditsSubapp;
