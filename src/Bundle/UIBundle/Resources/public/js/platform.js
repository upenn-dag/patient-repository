+function ($) { "use strict";

  var Accard = function() {};

  $.extend(Accard.prototype, {
    accessors: {},
    register: function(key, object) {
      this.accessors[key] = object;
    },
    get: function(key) {
      return this.accessors[key];
    },
    newInstance: function(key) {
      return new this.accessors[key];
    }
  });


   // URL Extension
   // ==============

  var URL = function(url) {
    var a =  document.createElement('a');
    var devregex = /_dev\.php/gi;

    a.href = url;

    this.source =  url;
    this.protocol = a.protocol.replace(':','');
    this.host = a.hostname;
    this.port = a.port;
    this.query = a.search;
    this.params = function() {
        var ret = {},
            rep = a.search.replace(/%25/g, '%'), // Proactively translate percentage sign encodings
            seg = rep.replace(/^\?/,'').split('&'),
            len = seg.length, i = 0, s;
        for (;i<len;i++) {
            if (!seg[i]) { continue; };
            s = seg[i].split('=');
            ret[s[0]] = s[1];
        }
        return ret;
    }();
    this.file = (a.pathname.match(/\/([^\/?#]+)$/i) || [0,''])[1];
    this.hash = a.hash.replace('#', '');
    this.path = a.pathname.replace(/^([^\/])/,'/$1');
    this.relative = (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [0, ''])[1];
    this.segments = a.pathname.replace(/^\//,'').split('/');

    if (this.segments && this.segments.length > 0) {
      this.dev = devregex.test(this.segments[0]) ? this.segments[0] : false;
    } else {
      this.dev = false;
    }
  }

  $.extend(URL.prototype, {
    buildParamString: function() {
      if (Object.keys(this.params).length) {
        var params = "?";
        $.each(this.params, function(param, content) {
          params += param + "=" + encodeURIComponent(content) + "&";
        }) 
      }

      return typeof params != "undefined" ? params.substring(0, params.length - 1) : "";
    },
    build: function() {
      return   this.protocol + "://" + this.host
             + (this.port ? ":" + this.port : "")
             + "/" + this.segments.join("/")
             + this.buildParamString()
             + (this.hash ? "#" + this.hash : "")
    },
    assign: function() { window.location.assign(this.build()); },
    reload: function() { window.location.reload(this.build()); },
    replace: function() { window.location.replace(this.build()); },
    appendSegment: function(segment) {
      this.segments.push(segment);
      return this;
    },
    popSegment: function() {
      this.segments.pop();
      return this;
    },
    prependSegment: function(segment) {
      this.segments.unshift(segment);
      return this;
    },
    addParam: function(name, value) {
      this.params[name] = value;
      return this;
    },
    getParam: function(name) {
      return typeof this.params[name] != "undefined" ? this.params[name] : null;
    },
    removeParam: function(name) {
      delete this.params[name];
    },
    isDev: function() {
      return false !== this.dev;
    },
    clone: function() {
      return new URL(this.build());
    },
    toString: function() {
      return this.build();
    }
  })


  // Generate default objects
  // =========================

  var AccardInstance = new Accard();
  AccardInstance.register("url", URL);
  AccardInstance.register("current_url", new URL(window.location.href));
  
  window.Accard = AccardInstance;

}(jQuery);
