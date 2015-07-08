var EventEmitter = require('events').EventEmitter;
var assign = require('object-assign');
var SERVER_EVENT = 'message-server-event';
var alert = window.alert;

var Server = function(providedWindow) {
  this.targetWindow = providedWindow || window;

  var targetWindow = this.targetWindow;
  var targetOrigin = this.getOrigin();
  var self = this;

  this.targetWindow.addEventListener('message', function(e) {
    // Only allow local communication, no cross-site or cross window.
    if (e.origin != targetOrigin) {
      alert('A cross-site scripting error has occurred and has been logged.');
      throw "Cross site or cross window detected";
    }

    // Only allow required data format.
    if (!e.data || !e.data.action) {
      throw "Invalid message format, please supply { action: 'name' } format";
    }

    return self._emit(e.data);
  });
};

Server.prototype = assign(Server.prototype, EventEmitter.prototype, {
  _emit(data) {
    return this.emit(SERVER_EVENT, data.action, data);
  },
  addServerListener(callback) {
    this.addListener(SERVER_EVENT, callback);
  },
  removeServerListener(callback) {
    this.removeListener(SERVER_EVENT, callback);
  },
  getWindow() {
    return this.targetWindow;
  },
  getOrigin() {
    return this.targetWindow.location.origin;
  },
  getServer() {
    return this.targetServer;
  },
  post(data) {
    return this.getWindow().postMessage(data, this.getOrigin());
  }
});

var server = new Server();


var Client = function(targetServer) {
  this.targetServer = targetServer || server;
};

Client.prototype.send = function(action, data) {
  // Validate data is an object and action is string.
  data = data || {};
  data.action = action;

  this.targetServer.post(data);
};

module.exports.mainServer = server;
module.exports.Server = Server;
module.exports.Client = Client;
