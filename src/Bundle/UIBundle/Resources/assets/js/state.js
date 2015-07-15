// Singleton, there can only be one state active...

var Immutable = require('immutable');
var singleton = false;

var State = function(state) {
  if (!state) throw 'No state provided.';
  this.data = Immutable.fromJS(state);
};

State.prototype.getData = function() {
  return this.data;
};

State.prototype.getObjects = function() {
  return this.data.get('objects');
};

State.prototype.getObject = function(object) {
  return this.data.getIn(['objects', object]);
};

State.prototype.isObjectPrototyped = function(object) {
  return this.data.getIn(['objects', object, 'isPrototyped']);
}

State.prototype.getObjectPrototypes = function(object) {
  if (!this.isObjectPrototyped(object)) return false;
  return this.data.getIn(['objects', object, 'prototypes']);
};

module.exports.init = function(state) {
  if (singleton) return singleton;
  singleton = new State(state);
  return singleton;
};

module.exports.get = function() {
  if (!singleton) throw 'State has not been initialized';
  return singleton;
}
