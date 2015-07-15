'use strict';

var React = require('react/addons');
var Bootstrap = require('react-bootstrap');
var PatientStore = require('./../../stores/patient/store');
var PatientActions = require('./../../stores/patient/actions');

// Bootstrap aliases
var Overlay = Bootstrap.OverlayTrigger;
var Tooltip = Bootstrap.Tooltip;
var Input = Bootstrap.Input;

function createStateFromStore() {
  var criteria = PatientStore.getCriteria();

  return {
    mrn: criteria.get('mrn') || '',
    firstName: criteria.get('firstName') || '',
    lastName: criteria.get('lastName') || '',
    dateOfBirth: criteria.get('dateOfBirth') || '',
    fromDate: criteria.get('fromDate') || '',
    toDate: criteria.get('toDate') || ''
  };
}

var PatientFilter = React.createClass({

  mixins: [React.addons.PureRenderMixin],

  getInitialState() {
    return createStateFromStore();
  },

  render() {

    var clearBtn = null;
    var refreshBtn = (<Bootstrap.Button bsSize='small' bsStyle='default' onClick={this.refresh}>Refresh</Bootstrap.Button>);

    if (PatientStore.isFiltered()) {
      clearBtn = (<Bootstrap.Button bsSize='small' bsStyle='default' onClick={this.clear}>Clear</Bootstrap.Button>);
    }

    return (
      <form onSubmit={function(e) { e.preventDefault() }}>
        <div className='row-fluid'>
          <div className='col-sm-12 col'>
              <Input type='text' bsSize='small' ref='mrn' placeholder='MRN' onChange={this._inputHandler('mrn')} value={this.state.mrn} />
          </div>
        </div>
        <div className='row-fluid'>
          <div className='col-sm-6 col'>
            <Input type='text' bsSize='small' ref='firstName' placeholder='First name' onChange={this._inputHandler('firstName')} value={this.state.firstName} />
          </div>
          <div className='col-sm-6 col'>
            <Input type='text' bsSize='small' ref='lastName' placeholder='Last name' onChange={this._inputHandler('lastName')} value={this.state.lastName} />
          </div>
        </div>
        <div className='row-fluid'>
          <div className='col-sm-6 col'>
            <Overlay placement='top' trigger='focus' overlay={<Tooltip>Date of birth from</Tooltip>}>
              <Input type='date' bsSize='small' ref='fromDate' placeholder='DOB: From' onChange={this._inputHandler('fromDate')} value={this.state.fromDate} />
            </Overlay>
          </div>
          <div className='col-sm-6 col'>
            <Overlay placement='top' trigger='focus' overlay={<Tooltip>Date of birth to</Tooltip>}>
              <Input type='date' bsSize='small' ref='toDate' placeholder='DOB: To' onChange={this._inputHandler('toDate')} value={this.state.toDate} />
            </Overlay>
          </div>
        </div>
        <div className='row-fluid'>
          <div className='col-sm-12 col'>
            <div className='pull-right'>
              <Bootstrap.Button bsSize='small' bsStyle='primary' onClick={this._handleFilter}>Filter</Bootstrap.Button>
              {clearBtn}
              {refreshBtn}
            </div>
          </div>
        </div>
        <div className='clearfix' />
      </form>
    );
  },

  clear() {
    PatientActions.resetCriteria();
    this.forceUpdate();
  },

  refresh() {
    PatientActions.load();
    this.forceUpdate();
  },

  filter(criteria) {
    PatientActions.setCriteria(criteria);
    this.forceUpdate();
  },

  _handleFilter(e) {
    var criteria = {
      mrn: this.state.mrn,
      firstName: this.state.firstName,
      lastName: this.state.lastName,
      dateOfBirth: this.state.dateOfBirth,
      fromDate: this.state.fromDate,
      toDate: this.state.toDate
    };

    this.filter(criteria);

    if (e.target && e.target.blur) {
      e.target.blur();
    }
  },

  _inputHandler(key) {
    var self = this;
    return function(e) {
      var changed = {};
      changed[key] = self.refs[key].getValue();
      self.setState(changed);
    };
  },

  componentDidMount() {
    PatientStore.addChangeListener(this._onChange);
  },

  componentWillUnmount() {
    PatientStore.removeChangeListener(this._onChange);
  },

  _onChange() {
    this.setState(createStateFromStore());
  }
});

module.exports = PatientFilter;
