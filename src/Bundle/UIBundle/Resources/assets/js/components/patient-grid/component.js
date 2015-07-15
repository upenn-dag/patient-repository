'use strict';

// Polyfill required for fixed data table
Object.assign = Object.assign || require('object-assign');

var React = require('react/addons');
var Bootstrap = require('react-bootstrap');
var FixedDataTable = require('fixed-data-table');
var Table = FixedDataTable.Table;
var Column = FixedDataTable.Column;
var Actions = require('./../../stores/patient/actions');
var Store = require('./../../stores/patient/store');
var Utils = require('./../../stores/patient/utils');

// var patients = Store.getAll();

var PatientGrid = React.createClass({

  mixins: [React.addons.PureRenderMixin],

  propTypes: {
    height: React.PropTypes.number.isRequired,
    width: React.PropTypes.number.isRequired,
    onRowClick: React.PropTypes.func,
    onRowDoubleClick: React.PropTypes.func
  },

  getInitialState: function() {
    return {
      height: this.props.height,
      patients: Store.getAll(),
      currentPatientId: Store.getCurrentPatientId(),
      sortKey: Store.getSortKey(),
      width: this.props.width
    };
  },

  _rowClickTimer: 0,
  _handleRowClickWithDoubleClick: function(e, index, patient) {
    if ((new Date() - this._rowClickTimer) < 500) {
      if (this.props.onRowDoubleClick) {
        this.props.onRowDoubleClick(e, index, patient);
      }
    } else {
      if (this.props.onRowClick) {
        this.props.onRowClick(e, index, patient);
      }
    }

    this._rowClickTimer = new Date();
  },

  render: function() {
    var btn;
    var rows = this.state.patients;
    var current = this.state.currentPatientId;
    var rowsCount = rows.size;
    var colWidth = (this.props.width / 6);
    var headerHeight = 50;
    //var rowHeight = ((this.state.height - headerHeight) / (rowsCount || 1));
    var rowHeight = 35;

    var rowGetter = function(index) {
      return rows.get(index).toJS();
    };

    var classGetter = function(index) {
      var patient = rows.get(index);
      var classes = ['accardFixedDataTableRow'];

      if (patient.id == this.state.currentPatientId) {
        classes.push('active');
      }

      return classes.join(' ');
    };

    if (Store.hasMorePatientsToLoad()) {
      btn = (<Bootstrap.Button onClick={Actions.loadMore} bsStyle='primary' block>Load More Patients</Bootstrap.Button>);
    }

    return (
      <div>
        <Table rowHeight={rowHeight}
               rowGetter={rowGetter}
               rowsCount={rowsCount}
               rowClassNameGetter={classGetter.bind(this)}
               width={this.state.width}
               maxHeight={this.state.height}
               headerHeight={headerHeight}
               onRowClick={this._handleRowClickWithDoubleClick}>
          <Column label={this._createSortableCellLabel('mrn', 'MRN')} fixed={true} cellClassName='accardFixedDataTableCell' width={colWidth*0.6} flexGrow={1} dataKey='mrn' headerRenderer={this._createHeaderRenderer} />
          <Column label={this._createSortableCellLabel('firstName', 'First Name')} cellClassName='accardFixedDataTableCell' width={colWidth*0.7} flexGrow={2} dataKey='firstName' headerRenderer={this._createHeaderRenderer} />
          <Column label={this._createSortableCellLabel('lastName', 'Last Name')} cellClassName='accardFixedDataTableCell' width={colWidth*0.7} flexGrow={2} dataKey='lastName' headerRenderer={this._createHeaderRenderer} />
          <Column label={this._createSortableCellLabel('dateOfBirth', 'Date of Birth')} cellClassName='accardFixedDataTableCell' width={colWidth*0.7} flexGrow={1} dataKey='dateOfBirth' headerRenderer={this._createHeaderRenderer} cellRenderer={this._createDateRenderer} />
          <Column label={this._createSortableCellLabel('gender', 'Gender')} cellClassName='accardFixedDataTableCell' width={colWidth*0.4} flexGrow={1} dataKey='gender' headerRenderer={this._createHeaderRenderer} cellRenderer={this._createGenderRenderer} />
          <Column label={this._createSortableCellLabel('race', 'Race')} cellClassName='accardFixedDataTableCell' width={colWidth-1} flexGrow={3} dataKey='race' headerRenderer={this._createHeaderRenderer} cellRenderer={this._createRaceRenderer} />
        </Table>
        {btn}
        <p className='text-muted text-center'>Double clicking on a patient record will open the patient details page.</p>
      </div>
    );
  },

  setSortKey: function(key, direction) {
    Actions.setSortKey(key, direction);
  },

  setSelectedPatient: function(patientId) {
    Actions.select(patientId);
  },

  _createSortableCellLabel: function(key, label) {
    var sortDirArrow = '';
    if (key == this.state.sortKey) {
      sortDirArrow = Store.getOppositeSortDirection() == 'asc' ? '↓ ' : ' ↑ ';
    }

    return sortDirArrow + label;
  },

  _createDateRenderer: function(cellData, cellDataKey, rowData, rowIndex, columnData, width) {
    var str = cellData ? Utils.createDateString(cellData) : null;

    return <div>{str}</div>;
  },

  _createGenderRenderer: function(cellData, cellDataKey, rowData, rowIndex, columnData, width) {
    return <div>{Store.translateGender(cellData)}</div>;
  },

  _createRaceRenderer: function(cellData, cellDataKey, rowData, rowIndex, columnData, width) {
    return <div>{Store.translateRace(cellData)}</div>;
  },

  _createHeaderRenderer: function(label, cellDataKey, columnData, rowData, width) {
    var clickHandler = function() {
      this.setSortKey(
        cellDataKey,
        cellDataKey == Store.getSortKey() ? Store.getOppositeSortDirection() : null
      );
    };

    return <div className="table-sorter" onClick={clickHandler.bind(this)}>{label}</div>;
  },

  componentDidMount: function() {
    Store.addChangeListener(this._onChange);
    Store.addCurrentPatientListener(this._onChange);

    Actions.load();
  },

  componentWillUnmount: function() {
    Store.removeChangeListener(this._onChange);
    Store.removeCurrentPatientListener(this._onChange);
  },

  _onChange: function() {
    this.setState({
      patients: Store.getAll(),
      currentPatientId: Store.getCurrentPatientId(),
      sortKey: Store.getSortKey()
    });
  }
});

module.exports = PatientGrid;
