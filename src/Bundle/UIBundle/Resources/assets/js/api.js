var Promise = window.Promise ? window.Promise : require('es6-promise').Promise;
var patientXHR, currentSet;

function loading() {
  window.status = 'Loading patients, please wait...';
  document.querySelector('html').style.cursor = 'wait';
}

function doneLoading() {
  window.status = 'Patients finished loading';
  document.querySelector('html').style.cursor = 'inherit';
}

function get(url) {
  return new Promise(function(resolve, reject) {
    var request = new XMLHttpRequest();
    request.open('GET', url);
    loading()
    request.key = url;

    request.onload = function() {
      doneLoading();
      if (request.status == 200) {
        resolve(request);
      } else {
        reject(Error(request.statusText));
      }
    };

    request.onerror = function() {
      doneLoading();
      reject(Error("Network Error"));
    };

    patientXHR = request;
    request.send();
  });
}

function getJSON(url) {
  return new Promise(function(resolve, reject) {
    var request = new XMLHttpRequest();
    request.open('GET', url);
    request.setRequestHeader('Accept', 'application/json');
    loading()
    request.key = url;

    request.onload = function() {
      doneLoading();
      if (request.status == 200) {
        resolve(JSON.parse(request.response));
      } else {
        reject(Error(request.statusText));
      }
    };

    request.onerror = function() {
      doneLoading();
      reject(Error("Network Error"));
    };

    patientXHR = request;
    request.send();
  });  
}

module.exports = {
  get: get,
  getJSON: getJSON,

  isLoading() {
    return !!patientXHR;
  },

  cancel() {
    if (patientXHR) {
      patientXHR.abort();
      patientXHR = null;
    }

    return this;
  }
};
