'use strict';

var Moment = require('moment');

module.exports = {
  createDateString: function(strDate) {
    return Moment(strDate.replace('+', '.')).format('MM/DD/YYYY');
  }
};
