'use strict';

var React = require('react');

var PatientsSubapp = React.createClass({
  render() {
    return (
      <div>
        <div className='accard-main-wrapper col-sm-7 col-md-9'>
          <div id='accard-grid' style={{ height: '100%', width: '100%' }} />
        </div>
        <div id='accard-inspector' className='col-sm-5 col-md-3 inset' />
      </div>
    );
  }
});

module.exports = PatientsSubapp;
