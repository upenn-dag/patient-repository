'use strict';

function randomId(upperLimit) {
  return Math.floor((Math.random() * (upperLimit || 100000)) + 1);
}

module.exports = {
  createSearchObject: function(term) {
    return {
      id: randomId(),
      term: term.trim(),
      time: (new Date()).getTime()
    };
  }
};
