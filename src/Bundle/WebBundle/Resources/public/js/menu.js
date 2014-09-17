;(function ($, window, document, undefined) {

    var pluginName = "menu",
        defaults = {
            toggle: true,
            toggle_ancestors: true,
            arrows: true
        };
        
    function Plugin(element, options) {
        this.element = element;
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype = {
        init: function () {

            var $this = $(this.element),
                $toggle = this.settings.toggle,
                $toggleAncestors = this.settings.toggle_ancestors,
                $arrows = this.settings.arrows;

            $this.find('li.active').has('ul').children('ul').addClass('collapse in');
            $this.find('li').not('.active').has('ul').children('ul').addClass('collapse');

            if ($arrows) {
                $this.find('li').has('ul').each(function(offset, ul) {
                    $(ul).find('a').first().append('<span class="fa arrow"></span>');
                });
            }

            if ($toggleAncestors) {
                $this.find('li.current').parents('li.ancestor').find('ul.nav').addClass('in');
            }

            $this.find('li').has('ul').children('a').on('click', function (e) {
                e.preventDefault();

                $(this).parent('li').toggleClass('active').children('ul').collapse('toggle');

                if ($toggle) {
                    $(this).parent('li').siblings().removeClass('active').children('ul.in').collapse('hide');
                }
            });


        }
    };

    $.fn[ pluginName ] = function (options) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin(this, options));
            }
        });
    };

})(jQuery, window, document);
