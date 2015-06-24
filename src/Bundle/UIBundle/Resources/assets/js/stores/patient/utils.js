'use strict';

module.exports = {
  createDateString: function(date) {
    return ('0' + date.getUTCMonth()).slice(-2) + '/'
         + ('0' + date.getUTCDay()).slice(-2) + '/'
         + (date.getUTCFullYear());
  }
};
