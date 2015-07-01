'use strict';

var React = require('react/addons');
var Bootstrap = require('react-bootstrap');
var AccardStore = require('./../../stores/accard/store');

var Brand = React.createClass({

  mixins: [React.addons.PureRenderMixin],

  propTypes: {
    tooltip: React.PropTypes.func, // Return false for no tooltip
    onClick: React.PropTypes.func.isRequired
  },

  getInitialState() {
    return {
      subApplication: AccardStore.getSubapplication()
    };
  },

  render() {

    var tooltip = this.props.tooltip(this.state.subApplication);

    var brand = (
      <a className="navbar-brand" rel="home" href="#" onClick={this.props.onClick}>
        <span className="fa fa-heartbeat animated infinite pulse"></span>
        ACCARD
      </a>
    );

    // Do no show tooltip if it's not added.
    if (false !== tooltip) {
      return (
        <Bootstrap.OverlayTrigger placement='right' overlay={<Bootstrap.Tooltip>{tooltip || 'Accard!'}</Bootstrap.Tooltip>}>
          {brand}
        </Bootstrap.OverlayTrigger>
      );
    }

    return brand;
  },

  componentDidMount() {
    AccardStore.addChangeListener(this._onChange);
  },

  componentWillUnmount() {
    AccardStore.removeChangeListener(this._onChange);
  },

  _onChange() {
    this.setState({ subApplication: AccardStore.getSubapplication() });
  }
});

module.exports = Brand;
