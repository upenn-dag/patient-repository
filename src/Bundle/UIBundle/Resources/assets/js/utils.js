'use strict';

module.exports = {
  createDateFromJSON: function(strDate) {
    console.log(strDate);
    var dateTime = strDate.split('T'); // [0] Date, [1] Time
    var ymd = dateTime[0].split('-'); // [0] Year, [1] Month, [2] Day
    var timeParts = dateTime[1].split('+'); // [0] Time, [1] Microseconds
    var his = timeParts[0].split(':'); // [0] Hour, [1] Minutes, [2] Seconds

    var date = new Date(ymd[0], ymd[1], ymd[2], his[0], his[1], his[2]);

    return date ? date : null;
  },
  createDateString: function(date) {
    return ('0' + date.getUTCMonth()).slice(-2) + '/'
         + (date.getUTCDay()).slice(-2) + '/'
         + (date.getUTCFullYear());
  }
};
