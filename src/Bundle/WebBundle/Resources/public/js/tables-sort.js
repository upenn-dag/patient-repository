+function ($, Accard) { "use strict";

  // SORT COLLECTION OBJECT
  // ======================

  var SortEvent = function(table, o) {
    this.table = table;
  }

  $.extend(SortEvent.prototype, {
    init: function() {
      var self = this;
      this.table.element.find("th.sorted").each(function(index, th) {
        var th = $(th), icon = $("<span class='pull-right glyphicon' />")

        if (th.has("a.asc").length) {
          icon.addClass("glyphicon-sort-by-alphabet")
        } else if (th.has("a.desc").length) {
          icon.addClass("glyphicon-sort-by-alphabet-alt")
        }

        th.find("a").parent().prepend(icon)
      })
    }
  })


  // TABLE PLUGIN DEFINITION
  // ========================

  if (Accard) {
    var Tabler = window.Accard.get("table")
    Tabler.registerPlugin("sorting", SortEvent);
  }

}(jQuery, Accard);
