'use strict';

var Inspectors = require('./inspector-registry');

function findInspector(name) {
  return Inspectors[name];
}

module.exports = {
  processInspector: function(inspector) {
    var processedInspector;

    if (typeof inspector.get('component') == 'string') {
      processedInspector = inspector.set('component', findInspector(inspector.get('component')));
    }

    return processedInspector || inspector;
  }
};
