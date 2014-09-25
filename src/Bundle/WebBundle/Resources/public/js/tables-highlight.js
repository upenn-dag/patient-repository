+function ($, Accard) { "use strict";

  // HIGHLIGHT TABLE EVENT
  // =====================

  var HighlightEvent = function(table, o) {
    this.table = table;
    this.className = o.className || "active";
    this.active = null;
  }

  $.extend(HighlightEvent.prototype, {
    init: function() {
      var self = this;
      this.table.element.on("click.accard.table", "tr", function(event) {
        self.active && self.active.removeClass(self.className)
        $(this).addClass(self.className);
        self.active = $(this);
      })
    }
  });


  // TABLE PLUGIN DEFINITION
  // ========================

  if (Accard) {
    var Tabler = window.Accard.get("table")
    Tabler.registerPlugin("highlighting", HighlightEvent);
  }


  // AUTO-HIGHLIGHT TABLE EVENT
  // ===========================

  var AutoHighlightEvent = function(table, o) {
    this.table = table;
    this.className = o.className || "active";
    this.providedId = o.id || 0;
    this.doAnimation = o.animate || false;
  }

  $.extend(AutoHighlightEvent.prototype, {
    init: function() {
      var self = this;
      var item = this.table.element.find('#'+this.providedId);

      if (this.doAnimation) {
        item.fadeOut('slow', function(event) { $(this).addClass(self.className); }).fadeIn('slow');
      } else {
        item.addClass(this.className);
      }
    }
  });


  // TABLE PLUGIN DEFINITION
  // ========================

  if (Accard) {
    var Tabler = window.Accard.get("table")
    Tabler.registerPlugin("autohighlighting", AutoHighlightEvent);
  }

}(jQuery, Accard);
