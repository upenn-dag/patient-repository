'use strict';

var React = require('react');

var Inspectors = {
  'default': require('./default-inspector'),
  'patientInspector': require('./patient-inspector'),
  'patientFilter': require('./patient-filter')
};

module.exports = Inspectors;
