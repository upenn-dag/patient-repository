;(function($, Modernizr) {

    // We need to be certain we have a jQuery object to work with.
    if (!$ || !Modernizr || !Modernizr.draganddrop) {
        console.log('Import drug javascript prerequisites failed.');
        return;
    }

    var noneHtml = '<span class="label label-danger">No drugs found</span>';

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
        var e = $.Event('accard.drug.enter', {
            container: $(this).data('drop-container')
        });
        $(this).trigger(e);
    }

    function handleDragLeave(event) {
        var e = $.Event('accard.drug.leave', {
            container: $(this).data('drop-container')
        });
        $(this).trigger(e);
    }

    function handleDrop(event) {
        var container = $(this).data('drop-container');
        var drugHtml = $(event.dataTransfer.getData('text/html')).last();
        var drugId = drugHtml.data('drug-id');
        var e;

        e = $.Event('accard.drug.pre_drop', {
            container: container,
            html: drugHtml,
            drug: drugId
        });

        drugHtml.removeAttr('draggable');
        container.el.trigger(e);

        if (container.hasNone()) {
            container.removeNone();
        }

        if (container.hasDrug(drugId)) {
            e = $.Event('accard.drug.reject_drop', {
                container: container,
                html: drugHtml,
                drug: drugId
            });
            container.el.trigger(e);
            return;
        }

        container.addDrug(drugId);
        container.addDrugHtml(drugHtml);

        e = $.Event('accard.drug.post_drop', {
            container: container,
            html: drugHtml,
            drug: drugId
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
        this.id = this.el.data('drug-container');

        this.initialize();
    };

    $.extend(DropContainer.prototype, {
        initialize: function() {
            var self = this;
            this.none = false;
            this.drugs = [];

            this.el.find('[data-drug-id]').each(function(index, drug) {
                self.addDrug($(drug).data('drug-id'));
            });

            this.el.find('[data-drug-none]').each(function(index, none) {
                self.none = noneHtml = none;
            });

            this.el.on('mouseenter', '[data-drug-id]', function(event) {
                var e = $.Event('accard.drug.mouseenter', {
                    container: self,
                    drug: event.currentTarget
                });
                $(this).trigger(e);
            });

            this.el.on('mouseleave', '[data-drug-id]', function(drug) {
                var e = $.Event('accard.drug.mouseleave', {
                    container: self,
                    drug: event.currentTarget
                });
                $(this).trigger(e);
            });
        },
        hasDrug: function(drug) {
            var retVal = false;
            this.drugs.forEach(function(item) {
                if (drug === item) retVal = true;
            });
            
            return retVal;
        },
        addDrug: function(drug) {
            this.drugs.push(drug);
        },
        removeDrug: function(drug) {
            var index = this.drugs.indexOf(drug);
            if (index) delete this.drugs[index];
        },
        addDrugHtml: function(drugHtml) {
            this.el.append(" ");
            this.el.append(drugHtml)
        },
        removeDrugHtml: function(drug) {
            this.el.find('[data-drug-id="' + drug + '"]').remove();
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
        this.id = this.el.data('drug-id');
        this.el.attr('draggable', true);
    }


    /**
     * Drug
     *
     * Initializes the containers and items.
     */

     var Drug = function(containerHolder, drugHolder) {
        this.containers = $(containerHolder).find('[data-drug-container]');
        this.drugs = $(drugHolder).find('[data-drug-id]');

        this.containers.each(function(index, container) {
            $(container).data('drop-container', new DropContainer(container));
        });

        this.drugs.each(function(index, drug) {
            $(drug).data('drop-item', new DropItem(drug));
        });
     }

     $.fn.accardDrug = function(drugHolder, options) {
        return this.each(function() {
            var $this = $(this);
            var data = $this.data('accard.drug');

            if (!data) {
                $this.data('accard.drug', (data = new Drug($this, $(drugHolder))));
            }
        });
     }

     $.fn.accardDrug.Constructor = Drug;

})(jQuery, Modernizr);