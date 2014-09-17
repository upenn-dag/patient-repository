;(function($, Modernizr) {

    // We need to be certain we have a jQuery object to work with.
    if (!$ || !Modernizr || !Modernizr.draganddrop) {
        console.log('Import code javascript prerequisites failed.');
        return;
    }

    var noneHtml = '<span class="label label-danger">No diagnosis codes found</span>';

    function getHTML(node){
        if(!node || !node.tagName) return '';
        if(node.outerHTML) return node.outerHTML;
        var wrapper = document.createElement('div');
        wrapper.appendChild(node.cloneNode(true));

        return wrapper.innerHTML;
    }

    function handleDragStart(event) {
        event.dataTransfer.effectAllowed = 'move';
        event.dataTransfer.setData('text/html', getHTML(this));
    };

    function handleDragOver(event) {
        event.dataTransfer.dropEffect = 'move';
        event.preventDefault();
        return false;
    }

    function handleDragEnter(event) {
        var e = $.Event('accard.code.enter', {
            container: $(this).data('drop-container')
        });
        $(this).trigger(e);
    }

    function handleDragLeave(event) {
        var e = $.Event('accard.code.leave', {
            container: $(this).data('drop-container')
        });
        $(this).trigger(e);
    }

    function handleDrop(event) {
        var container = $(this).data('drop-container');
        var codeHtml = $(event.dataTransfer.getData('text/html')).last();
        var codeId = codeHtml.data('code-id');
        var e;

        e = $.Event('accard.code.pre_drop', {
            container: container,
            html: codeHtml,
            code: codeId
        });

        codeHtml.removeAttr('draggable');
        container.el.trigger(e);

        if (container.hasNone()) {
            container.removeNone();
        }

        if (container.hasCode(codeId)) {
            e = $.Event('accard.code.reject_drop', {
                container: container,
                html: codeHtml,
                code: codeId
            });
            container.el.trigger(e);
            return;
        }

        container.addCode(codeId);
        container.addCodeHtml(codeHtml);

        e = $.Event('accard.code.post_drop', {
            container: container,
            html: codeHtml,
            code: codeId
        });

        container.el.trigger(e);

        event.stopPropagation();
        return false;
    }

    function handleDragEnd(event) {}


    /**
     * Droppable container.
     */
    var DropContainer = function(el) {
        this.el = $(el);
        el.addEventListener('dragenter', handleDragEnter, false);
        el.addEventListener('dragover', handleDragOver, false);
        el.addEventListener('dragleave', handleDragLeave, false);
        el.addEventListener('drop', handleDrop, false);
        this.id = this.el.data('code-container');

        this.initialize();
    };

    $.extend(DropContainer.prototype, {
        initialize: function() {
            var self = this;
            this.none = false;
            this.codes = [];

            this.el.find('[data-code-id]').each(function(index, code) {
                self.addCode($(code).data('code-id'));
            });

            this.el.find('[data-code-none]').each(function(index, none) {
                self.none = noneHtml = none;
            });

            this.el.on('mouseenter', '[data-code-id]', function(event) {
                var e = $.Event('accard.code.mouseenter', {
                    container: self,
                    code: event.currentTarget
                });
                $(this).trigger(e);
            });

            this.el.on('mouseleave', '[data-code-id]', function(code) {
                var e = $.Event('accard.code.mouseleave', {
                    container: self,
                    code: event.currentTarget
                });
                $(this).trigger(e);
            });
        },
        hasCode: function(code) {
            var retVal = false;
            this.codes.forEach(function(item) {
                if (code === item) retVal = true;
            });
            
            return retVal;
        },
        addCode: function(code) {
            this.codes.push(code);
        },
        removeCode: function(code) {
            var index = this.codes.indexOf(code);
            if (index) delete this.codes[index];
        },
        addCodeHtml: function(codeHtml) {
            this.el.append(" ");
            this.el.append(codeHtml)
        },
        removeCodeHtml: function(code) {
            this.el.find('[data-code-id="' + code + '"]').remove();
        },
        hasNone: function() {
            return this.none;
        },
        addNone: function() {
            this.el.trigger(e).prepend(e.none);
        },
        removeNone: function() {
            if (this.none) $(this.none).detach();
        }
    });


    /**
     * Droppable item.
     */

    var DropItem = function(el) {
        this.el = $(el);
        el.addEventListener('dragstart', handleDragStart, false);
        el.addEventListener('dragend', handleDragEnd, false);
        this.id = this.el.data('code-id');
        this.el.attr('draggable', true);
    }


    /**
     * Code
     *
     * Initializes the containers and items.
     */

     var Code = function(containerHolder, codeHolder) {
        this.containers = $(containerHolder).find('[data-code-container]');
        this.codes = $(codeHolder).find('[data-code-id]');

        this.containers.each(function(index, container) {
            $(container).data('drop-container', new DropContainer(container));
        });

        this.codes.each(function(index, code) {
            $(code).data('drop-item', new DropItem(code));
        });
     }

     $.fn.accardCode = function(codeHolder, options) {
        return this.each(function() {
            var $this = $(this);
            var data = $this.data('accard.code');

            if (!data) {
                $this.data('accard.code', (data = new Code($this, $(codeHolder))));
            }
        });
     }

     $.fn.accardCode.Constructor = Code;

})(jQuery, Modernizr);