+function ($, Accard) { "use strict";

  // FORM CLASS DEFINTION
  // ====================

  var Form = function(el) {
    this.element = $(el);
    this.bindGroups = {
      global: []
    };
    this.activeBindGroup = "global";
    this.plugins = {};
    this.dynamics = [];
    this.url = Accard.get("current_url");
  };

  Form.resolve = function(form, element, source) {
    if (typeof element == "string") {
      var firstChar = element.charAt(0);
      if (firstChar != "#" && firstChar != "." && firstChar != "[") {
        return form.find("[name$='" + element + "]']");
      }
    } else if (typeof element == "function") {
      element = element.call(source, form);
    }

    return $(element)
  };

  Form.plugins = {};

  Form.registerPlugin = function(plugin, object) {
    Form.plugins[plugin] = object
  }

  Form.getPlugin = function(plugin) {
    return Form.plugins[plugin]
  }

  $.extend(Form.prototype, {

    _attachItem: function(source, conditions, event) {
      var item = Form.resolve(this.element, source)
        , data = item.data("accard.form.item")
        , active = this.activeBindGroup

      conditions = conditions || {}
      conditions.source = item

      var formEvent = new event(this, conditions)

      if (!data) {
        data = new FormItem(item, this)
        item.data("accard.form.item", data)
        this.bindGroups[active].push(data)
      }

      data.addEvent(formEvent)

      return this
    },

    activeGroup: function(namespace) {
      this.activeBindGroup = namespace

      return this
    },

    behavior: function(source, conditions) {
      return this._attachItem(source, conditions, FormBehaviorEvent)
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

    collection: function(source, conditions) {
      return this._attachItem(source, conditions, FormCollectionEvent)
    },

    dynamic: function(regex, conditions) {
      this.dynamics.push({ regex: regex, conditions: conditions })
      
      return this
    },

    filter: function(filter) {
      return this.element.find(filter)
    },

    filterByAttr: function(attr, regex) {
      return this.element.find(":input").filter(function(index) {
        return regex.test($(this).attr(attr))
      })
    },

    filterById: function(regex) {
      return this.filterByAttr("id", regex)
    },

    filterByName: function(regex) {
      return this.filterByAttr("name", regex)
    },

    find: function(selector) {
      return Form.resolve(this, selector)
    },

    getInputs: function() {
      return this.element.find(":input")
    },

    plugin: function(plugin, source, conditions) {
      var plugin = Form.plugins[plugin]
      if (!plugin) throw "Plugin '" + plugin + "' not registered";

      return this._attachItem(source, conditions, plugin)
    },

    polycollection: function(source, conditions) {
      return this._attachItem(source, conditions, FormPolyCollectionEvent)
    },

    url: function(url) {
      return typeof url == "undefined" ? this.url : new URL(url)
    }
  })


  // FORM ITEM CLASS DEFINITION
  // ==========================

  var FormItem = function($el, form) {
    this.form = form
    this.element = $el
    this.events = []
    this.values = [$el.val()]
  }

  $.extend(FormItem.prototype, {

    addEvent: function(event) {
      this.events.push(event)
    },

    init: function() {
      var self = this
      $.each(this.events, function(index, event) {
        if (event.event) {
          var eventString = typeof event.event == "object" ? event.event.join(" ") : event.event
          self.element.on(eventString, function() {
            self.values.push($(this).val())
            event.execute()
          })
        }

        // Trigger once if required
        if (event.init) event.execute()
      })
    },

    getCurrentValue: function() {
      return this.values[this.values.length - 1]
    },

    getInitialValue: function() {
      return this.values[0]
    },

    getPreviousValue: function(offset) {
      return this.values[this.values.length - (typeof offset == "number" ? offset + 1 : 2)]
    }
  })


  // FORM COLLECTION EVENT CLASS DEFINITION
  // ======================================

  var FormCollectionEvent = function(form, o) {
    o = o || {}
    if (!o.source) throw "Source element not defined"

    var $form = form.element

    this.form = form
    this.source = Form.resolve($form, o.source)
    this.proto = this.source.data("prototype")
    this.indexer = typeof o.indexer == "undefined" ? ".row" : o.indexer
    this.index = this.source.find(this.indexer).length

    if (typeof o.adder == "undefined") {
      this.adder = this.source.find("[data-accard='add']")
    } else if (typeof o.adder == "string") {
      this.adder = Form.resolve(o.adder)
    } else {
      this.adder = o.adder
    }

    this.startup = (typeof o.startup == "function") ? o.startup : function() {}
    this.adder.attr("data-accard", "add")
  }

  $.extend(FormCollectionEvent.prototype, {
    event: null,
    init: true,
    execute: function() {
      var self = this

      this.adder.click(function(event) {
        event.preventDefault()
        var fixed = $(self.proto.replace(/__name__/g, self.index))

        self.index = self.index + 1;
        self.source.append(fixed);
        fixed.addClass('accard-collection-item');
        self._attachBehaviors(fixed);
        self.startup.call(fixed, self);

        self.form.bindAll();
      })

      // Work out already existing collection items and run behavior
      // attachment and collection startup function.
      var proto = $(this.proto.replace(/__name__/g, this.index)).get(0)
        , localName = proto.localName
        , currents = this.source.children(localName)

      currents.each(function(index, current) {
        var $current = $(current);
        self.index = self.index + 1;
        self._attachBehaviors($current);
        self.startup.call($current, self);
        $current.addClass('accard-collection-item');
      })

      // We need to add in some delete behavior based on the indexes above.
      this.source.on("click", "[data-accard='delete']", function(event) {
        event.preventDefault();
        var $this = $(this);
        var toDelete = $this.parents('.accard-collection-item').first();
        var confirm = $this.is('[data-accard-confirm]');

        if (confirm) {
          var confirmText = $this.data('accard-confirm');
          var isConfirmed = window.confirm(confirmText);

          if (!isConfirmed) {
            return;
          }
        }

        toDelete.remove();
      })
    },
    _attachBehaviors: function(source) {
      var self = this, inputs = source.find(":input")
      this.form.dynamics.forEach(function(dynamic) {
        var input = inputs.filter(function() { return this.name.match(dynamic.regex) })
        if (input.length > 0) {
          self.form.behavior(input, dynamic.conditions)
        }
      })
    }
  })

  var FormPolyCollectionEvent = function(form, o) {
    o = o || {}
    if (!o.source) throw "Source element not defined"

    var $form = form.element

    this.form = form
    this.source = Form.resolve($form, o.source)
    this.indexer = typeof o.indexer == "undefined" ? ".row" : o.indexer
    this.index = this.source.find(this.indexer).length
    this.protos = {}

    var protos = this.source.data("prototypes").split(",")
      , self = this

    protos.forEach(function(proto) {
      var key = "prototype-" + proto
        , template = self.source.data(key)

      if (template) {
        self.protos[proto] = self.source.data(key)
      } else {
        throw "No template defined in data-" + key
      }
    })

    this.startup = (typeof o.startup == "function") ? o.startup : function() {}
  }

  $.extend(FormPolyCollectionEvent.prototype, {
    event: null,
    init: true,
    execute: function() {
      var self = this

      $("body").on("click", "[data-accard='poly']", function(event) {
        event.preventDefault()
        var template = $(this).data("accard-add")

        if (!template || !self.protos[template]) throw "Misconfigured adder or prototype definition"

        var fixed = $(self.protos[template].replace(/__name__/g, self.index))

        self.index = self.index + 1
        self.source.append(fixed)
        self._attachBehaviors(fixed)
        self.startup.call(fixed, self)

        self.form.bindAll()
      })
    },
    _attachBehaviors: function(source) {
      var self = this, inputs = source.find(":input")
      this.form.dynamics.forEach(function(dynamic) {
        var input = inputs.filter(function() { return this.name.match(dynamic.regex) })
        if (input.length > 0) {
          self.form.behavior(input, dynamic.conditions)
        }
      })
    }
  })


  // FORM BEHAVIOR EVENT CLASS DEFINITION
  // ====================================

  var FormBehaviorEvent = function(form, o) {
    o = o || {}
    if (!o.source) throw "Source element not defined"
    if (!o.target) throw "No target defined"

    var $form = form.element

    this.source = Form.resolve($form, o.source)

    if (typeof o.target == jQuery) {
      this.target = o.target
    } else if (typeof o.target == "string") {
      this.target = Form.resolve($form, o.target, this.source)
    } else if (typeof o.target == "function") {
      this.target = o.target.call(this.source)
    } else {
      var targets = $("#targets-holster")
        , self = this

      $.each(o.target, function(target) {
        targets = targets.add(Form.resolve($form, target, self.source))
      })

      this.target = targets
    }

    this.event = typeof o.event != "undefined" ? o.event : "change"
    this.init = typeof o.init != "undefined" ? o.init : true

    var condition = o.condition || function() { return true }
    if (typeof condition === "function") {
      this.condition = condition
    } else if (typeof condition === "object") {
      condition = condition.slice()
      var _condition = condition.shift()
      this.condition = typeof _condition == "function" ? _condition : this.conditions[_condition]
      this.condition_args = condition
    } else {
      this.condition = this.conditions[condition]
    }

    var action = o.action || function() {}
    if (typeof action === "function") {
      this.action = action
    } else if (typeof action === "object") {
      var _action = action.shift()
      this.action = typeof _action == "function" ? _action : this.actions[_action]
      this.action_args = action
    } else {
      this.action = this.actions[action]
    }
  }

  $.extend(FormBehaviorEvent.prototype, {

    source: null,
    target: null,
    event: null,
    condition: null,
    condition_args: [],
    action: null,
    action_args: [],
    init: true,

    execute: function() {
      var result = this.condition.apply(this.source, this.condition_args)
        , args = this.action_args.slice(0)

      args.unshift(result)
      args.unshift(this)

      return this.action.apply(this.target, args)
    },

    conditions: {
      changed: function() { return true; },
      checked: function() { return $(this).is(":checked") },
      not_checked: function() { return !$(this).is(":checked") },
      selected: function(options) { return $.inArray($(this).val(), options) !== -1 },
      not_selected: function(options) { return $.inArray($(this).val(), options) === -1 },
      empty: function() { return $(this).val() ? false : true },
      not_empty: function() { return $(this).val() ? true : false },
      greater: function(mixed) { return $(this).val() > mixed },
      lesser: function(mixed) { return $(this).val() < mixed },
      equal: function(mixed) { return $(this).val() == mixed },
      not_equal: function(mixed) { return $(this).val() != mixed },
      strict_equal: function(mixed) { return $(this).val() === mixed },
      regexp: function(regexp) { return regexp.test($(this).val()) }
    },

    actions: {
      show: function(event, result) { result ? $(this).show() : $(this).hide() },
      hide: function(event, result) { result ? $(this).hide() : $(this).show() },
      clear: function(event, result) {
        if (result) {
          $(this).is(":checkbox") ? $(this).prop("checked", false) : $(this).val(null)
        }
      },
      enable: function(event, result) { $(this).prop('disabled', !result) },
      disable: function(event, result) { $(this).prop('disabled', result) },
      set: function(event, result, value) { if (result) $(this).val(value) },
      copy: function(event, result) { if (result) $(this).val(event.source.val()) },

      // Slug behavior
      slug: function(event, result) {
        event.target.val(event.source.val().toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-'));
        event.target.prop('readonly', true);
      },

      // Callback is provided with the FormItem directly
      callback: function(event, result, callback) { if (result) callback.call($(this).data("accard.form.item"), result) }
    }
  })

  // FORM PLUGIN DEFINITION
  // =======================

  $.fn.accardForm = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data  = $this.data('accard.form')

      if (!data) $this.data('accard.form', (data = new Form(this)))
    })
  }

  $.fn.accardForm.Constructor = Form

  if (Accard) {
    Accard.register("form", Form);
    Accard.register("form-behavior", FormBehaviorEvent);
    Accard.register("form-collection", FormCollectionEvent);
  }

}(jQuery, window.Accard);
