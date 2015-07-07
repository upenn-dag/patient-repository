'use strict';

var Moment = require('moment');

module.exports = {
  createDateString: function(strDate) {
    return new Moment(strDate.replace('+', '.')).format('MM/DD/YYYY');
  }
};
