+function ($, Accard) { "use strict";

  function simpleInjector(getter) {
    return function(value) {
      var field = this.form.find("[name*='" + getter + "']")
      if (value && field && !field.val()) field.val(value)
    }
  }

  function dateInjector(getter) {
    return function(date) {
      var field = this.form.find("[name*='dateOfBirth']")
      if (date && field && !field.val()) field.val(date.toISOString().substr(0,10))
    }
  }


  // EXTEND ACCARD FORM IF PRESENT
  // =============================

  var FormPDSEvent = function(form, o) {
    o = o || {}
    this.source = o.source
    this.form = form
    this.url = o.source.data("pds-url")
    this.field = form.find((typeof o.field != "undefined") ? o.field : "mrn")
    this.field_callback = (typeof o.field_callback == "function") ? o.field_callback : function() {}
  }

  $.extend(FormPDSEvent.prototype, {
    source: null,
    form: null,
    url: null,
    field: null,
    field_callback: null,
    init: true,
    event: null,

    execute: function() {
      var self = this
      this.source.on("click.accard.pds", function(event) {
        var mrn, url
        if (mrn = self.field.val()) {
          mrn = self._makeMRN(mrn)
          if (isNaN(mrn)) {
            alert("MRN '" + mrn + "'' is not a valid MRN"); return
          }
        } else {
          alert("No valid MRN could be located, aborting"); return
        }

        self.query(self.url.replace("000000000", mrn))
        event.preventDefault()
      })
    },

    _makeMRN: function(s) {
      var p = "000000000"; return p.substring(0, p.length - s.length) + s
    },

    prepare: function(json) {
      // Format dates
      if (json.date_of_birth) json.date_of_birth = new Date(json.date_of_birth)
      if (json.date_of_death) json.date_of_death = new Date(json.date_of_death)
      if (json.last_modified) json.last_modified = new Date(json.last_modified)

      return json
    },

    inject: function(json) {console.log(json)
      var self = this
      $.each(this.mappings, function(field, mapping) {
        switch ($.type(mapping)) {
          case "string":
            var $field = self.form.find(mapping)
            if ($field && !$field.val() && json[field]) {
              $field.val(json[field])
            }
            break;
          case "function":
            mapping.call(self, json[field])
            break;
        }
      })
    },

    query: function(url) {
      var self = this
        , ajax = $.ajax({ url: url })

      ajax
        .done(function(request) {

          if (!request) {
            alert("Unable to locate patient in Penn Data Store"); return
          }

          self.inject(self.prepare(request))
          self.source.attr("disabled", "disabled")
        })
        .fail(function(request) {
          alert("PDS query failure")
        })
    },

    // Default field mappings
    mappings: {
      prefix: "prefix",
      first_name: "firstName",
      middle_name: "middleName",
      last_name: "lastName",
      suffix: "suffix",
      generation: null,

      email: "email",
      home_phone: null,
      work_phone: null,
      mobile_phone: null,

      is_deceased: null,
      date_of_birth: dateInjector("dateOfBirth"),
      date_of_death: dateInjector("dateOfDeath"),

      gender: function(value) {
        var field = this.form.find("[name*='gender']");
        if (field) {
          switch(value) {
            case "MALE": value = 101; break;
            case "FEMALE": value = 102; break;
            case "UNKNOWN": value = 2; break;
            default: value = 0;
          }
          field.val(value);
        }
      },
      race: function(value) {
        var field = this.form.find("[name*='race']");
        if (field) {
          switch(value) {
            case "AMERICAN INDIAN OR ALASKAN NATIVE": value = "AI"; break;
            case "ASIAN": value = "AS"; break;
            case "BLACK OR AFRICAN AMERICAN": value = "BL"; break;
            case "NATIVE HAWAIIAN OR OTHER PACIFIC ISLANDER": value = "PI"; break;
            case "WHITE": value = "WH"; break;
            case "UNKNOWN": value = "UN"; break;
            case "OTHER": value = "OT"; break;
            default: value = "NR"; break;
          }
        }
      },
      race_mixed: null,
      is_hispanic: null,

      marital_status: null,
      mrn: null,
      social_security_number: "social",
      last_modified: null,

      address_1: simpleInjector("addresses][0][line]"),
      address_2: null,
      city: simpleInjector("addresses][0][city]"),
      state: "state",
      zip: "zip"
    }
  })

  if (typeof Accard !== "undefined") {
    Accard.get("form").registerPlugin("pds", FormPDSEvent)
  }

}(jQuery, window.Accard);
