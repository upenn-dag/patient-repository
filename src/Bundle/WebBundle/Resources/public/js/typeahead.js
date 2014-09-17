+function ($, Accard) { "use strict";

  var FormTypeaheadEvent = function(form, o) {
    o = o || {}
    this.source = o.source
    this.form = form

    var url = window.Accard.get("current_url");

    
    url.addParam("typeahead_search", "123")
    
    this.url = url.build().replace("123", "%QUERY")

    var engine = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
        url: this.url,
        filter: function(list) { return list.results } 
      }
    })

    engine.initialize()

    var widget = this.source;
    
    this.newSource = widget.clone();

    this.newSource.attr("name", "")
    widget.attr("type", "hidden")
    widget.attr("id", widget.attr("id") + "_hidden")
    widget.parent().append(this.newSource)
    widget.data("accard.form.typeahead_widget", this.newSource)

    this.newSource.typeahead(null, {
      name: "typeahead-source",
      displayKey: "label",
      valueKey: "id",
      source: engine.ttAdapter()
    })
    .on("typeahead:selected typeahead:autocompleted", function(event, datum) {
      widget.val(datum.id)
    })
    .on("focus", function() {
      var self = $(this)
      window.setTimeout(function() { self.select() }, 100)
    })
  }

  $.extend(FormTypeaheadEvent.prototype, {
    source: null,
    newSource: null,
    form: null,
    url: null,
    init: false,
    event: null,
    execute: function() {}
  })

  if (Accard) {
    Accard.get("form").registerPlugin("typeahead", FormTypeaheadEvent)
  }

}(jQuery, window.Accard);