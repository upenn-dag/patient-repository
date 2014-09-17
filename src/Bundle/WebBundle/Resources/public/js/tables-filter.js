+function ($, Accard) { "use strict";

  // FILTER COLLECTION OBJECT
  // =========================

  var FilterCollection = function(table, opts) {
    var self = this
      , form = $(table.element.data("filter-prototype"));

    if (!form) throw "Supplied form does not have a filter prototype"

    this.opts = opts || {};
    this.table = table;
    this.groups = {};
    this.groupOrder = [];

    form.find("[data-filter-field]").each(function(index, group) {
      var obj = new FilterGroup(group);
      self.groups[obj.getField()] = obj;
      self.groupOrder.push(obj.getField());
    })

    this._submitButtonHTML = form.find("[type=submit]").first().parent().html();
    this._blankFormHTML = form.clone().html("").wrap("<div>").parent().html();
  }

  $.extend(FilterCollection.prototype, {
    countGroups: function() { return this.groupOrder.lengthl },
    createBlankForm: function() { return $(this._blankFormHTML); },
    createBlankSubmit: function() { return $(this._submitButtonHTML); },
    getGroup: function(index) { return $.isNumeric(index) ? this.groups[this.groupOrder[index]] : this.groups[index]; },
    getGroups: function() { return this.groups; },
    sortGroups: function(closure) { return closure ? this.groupOrder.sort(closure) : this.groupOrder.sort(); }
  });


  // FILTER GROUP OBJECT
  // ====================

  var FilterGroup = function(el) {
    el = $(el);
    var filterEl = el.find("[data-filter]:first")
      , labelEl = el.find("label:first")
      , filters = filterEl.find("[data-filter] > input");

    this._el = el;
    this.filter = new Filter(filterEl);
    this.label = new Label(labelEl);
    this._compound = filterEl.data("filter-compound") ? true : false;
    this.field = this._compound ? [filters.first(), filters.last()] : filterEl.find("input");
  }

  $.extend(FilterGroup.prototype, {
    isActive: function() {
      if (this._compound) {
        var active = false;
        $(this.field).each(function(index, item) {
          active = ($(this).val() && $(this).val().length > 0) ? true : active;
        })

        return active;
      } else {
        return this.field.val() && this.field.val().length > 0
      }
    },
    getElement: function() { return this._el; },
    getField: function() { return this._el.data("filter-field"); },
    getFilter: function() { return this.filter; },
    getLabel: function() { return this.label; },
    getValue: function() { return this._compound ? [this.field[0].val(), this.field[1].val()] : this.field.val(); },
    isCompound: function() { return this._compound; }
  })


  // FILTER OBJECT
  // ==============

  var Filter = function(el) {
    this._el = $(el);
  };

  $.extend(Filter.prototype, {
    getElement: function() { return this._el; },
    getType: function() { return this._el.data("filter"); }
  });


  // FILTER LABEL OBJECT
  // ====================

  var Label = function(el) {
    this._el = $(el);
  };

  $.extend(Label.prototype, {
    getElement: function() { return this._el; },
    getText: function() { return this._el.text(); }
  });


  // TABLE FILTER EVENT
  // ===================

  var FilterEvent = function(table, o) {
    this.table = table;
    this.filters = new FilterCollection(this.table);
    this.url = Accard.get("current_url").clone();
  }

  $.extend(FilterEvent.prototype, {
    init: function() {
      var self = this;
      this.table.element.find("th[data-filter-field]").each(function(index, item) {
        var $this = $(this);
        var icon = $("<span class='pull-right glyphicon glyphicon-filter'></span>");
        var group = self.filters.getGroup($this.data("filter-field"));

        if (group) {
          if (group.isActive()) {
            $this.addClass("filtered");
          }

          var blank = self.filters.createBlankForm()
            .append(group.getElement().html())
            .append(self.filters.createBlankSubmit())
            .submit(function(event) {
              $($(this).serializeArray()).each(function(index, datum) {
                if (datum.value.length) {
                  self.url.addParam(datum.name, datum.value);
                } else {
                  self.url.removeParam(datum.name);
                }
              })

              self.url.replace();
              event.preventDefault();
            })
          ;

          icon.popover({
            html: true,
            placement: "bottom",
            container: $("body"),
            content: blank
          })

          $this.append(icon);
        }
      })
    }
  });

  // TABLE PLUGIN DEFINITION
  // ========================

  if (Accard) {
    var Tabler = window.Accard.get("table")
    Tabler.registerPlugin("filtering", FilterEvent);

    // Deprecated, use "filtering".
    Tabler.registerPlugin("filters", FilterEvent);
  }

}(jQuery, Accard);
