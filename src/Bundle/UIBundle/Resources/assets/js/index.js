'use strict';

var Promise = require('bluebird');
var API = require('./api');
var initConfig = window.accardConfig || {};

function start(config) {
  return new Promise(function(resolve, reject) {
    resolve(config);
  });
}

start(initConfig)
  
  .then(function(config) {
    return Promise.all([
      API.get(config.urls.state),
      API.get(config.urls.routes)
    ]);
  })

  .then(function(responses) {
    responses.forEach(function(response) {
      switch (response.key) {
        case initConfig.urls.state:
          initConfig.state = JSON.parse(response.response);
        break;
        case initConfig.urls.routes:
          initConfig.routes = JSON.parse(response.response);
        break;
      }
    });

    return new Promise(function(resolve, reject) {
      resolve(initConfig);
    });
  })

  .then(function() {
    return new Promise(function(resolve, reject) {
      var Accard = require('./accard');
      var accard = new Accard();
      resolve(accard);
    });
  })

  .then(function(accard) {
    window.accard = accard;
    accard.initialize(initConfig);
    accard.initMessaging();

    // TEST TEST TEST BELOW!!!

    var server = accard.getMessagingServer();

    server.addServerListener(function(action, data) {
      switch (action) {
        case 'modal':
          accard.openModal(data.url, data.onHide);
        break;
        case 'set-patient':
          accard.activatePatient(data.patient);
        break;
        case 'close-modal':
          accard.closeModal();
        break;
      }
    });
  })
;
