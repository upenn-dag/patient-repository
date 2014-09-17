+function ($, Accard) { "use strict";

  // TABLE CLASS DEFINTION
  // =====================

  var Table = function(el) {
    this.element = $(el)
    this.element.data("accard.table", this)
    this.bindGroups = {
      global: []
    }
    this.activeBindGroup = "global"
    this.identifier = "table-accard-" + (~~(Math.random() * 999) + 1);

    this.addClass(this.identifier);
  }

  Table.plugins = {}

  Table.registerPlugin = function(plugin, object) {
    Table.plugins[plugin] = object
  }

  Table.getPlugin = function(plugin) {
    return Table.plugins[plugin]
  }

  $.extend(Table.prototype, {

    _attachEvent: function(conditions, tableEvent) {
      var active = this.activeBindGroup

      conditions = conditions || {}
      tableEvent = new tableEvent(this, conditions)
      this.bindGroups[active].push(tableEvent)

      return this
    },

    addClass: function(classString) {
      return this.element.addClass(classString);
    },

    bindAll: function() {
      var active = this.activeBindGroup
      this.bindGroups[active].forEach(function(item) { item.init() })
      this.clearGroup(active)
      this.activeBindGroup = "global"

      return this
    },

    bindGroup: function(namespace) {
      this.bindGroups[namespace] = []
      this.activeBindGroup = namespace

      return this
    },

    clearGroup: function(namespace) {
      var active = typeof namespace == "undefined" ? this.activeBindGroup : namespace
      this.bindGroups[active] = []

      return this
    },

    filter: function(conditions) {
      return this.plugin("filtering", conditions || {});
    },

    plugin: function(plugin, conditions) {
      var plugin = Table.plugins[plugin]
      if (!plugin) throw "Plugin '" + plugin + "' not registered";

      return this._attachEvent(conditions, plugin);
    },

    removeClass: function(classString) {
      return this.element.removeClass(classString);
    },

    sortable: function(conditions) {
      return this.plugin("sorting", conditions || {});
    },

    highlightable: function(className) {
      return this.plugin("highlighting", { className: className || "active" });
    }
  })


  // FORM PLUGIN DEFINITION
  // =======================

  if (Accard) {
    Accard.register("table", Table)
  }

}(jQuery, window.Accard);
