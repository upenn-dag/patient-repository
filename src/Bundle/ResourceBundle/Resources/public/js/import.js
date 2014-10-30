;(function($) {

    // We need to be certain we have a jQuery object to work with.
    if (!$) {
        console.log('jQuery import javascript is disabled because there is no jQuery loaded.');
        return;
    }

    var modal = $('#record-details');
    var modalAccept = $('#modal-accept');
    var modalDecline = $('#modal-decline');

    // Empty out the modal details when it is finished closing.
    modal.on('hidden.bs.modal', function(event) {
        setModalAttributes('', '', '', '');
    });


    function highlightRow(id, type) {
        $('tr#patient-'+id).addClass(type);
    }

    function removeButtons(id, message) {
        $('tr#patient-'+id).find('td').last().html(message ? message : '');
    }

    function setModalAttributes(content, id, acceptHref, declineHref) {
        modal.find('.modal-body').html(content);
        modalAccept.data('record-id', id).attr('href', acceptHref);
        modalDecline.data('record-id', id).attr('href', declineHref);
    }


    // Intercept clicks, and replace with AJAX requests.
    $('body').on('click', 'a[data-import]', function(event) {
        var $this = $(this);
        var method = $this.data('import');
        var id = $this.data('record-id');
        var jqxhr = $.ajax(this.href).fail(function() {
                highlightRow(id, 'warning');
            });

        // The show action must alter and present the modal dialog.
        if ('show' === method) {
            var accept = $this.parent().find('[data-import="accept"]');
            var decline = $this.parent().find('[data-import="decline"]');
            setModalAttributes('', id, accept.attr('href'), decline.attr('href'));

            jqxhr.done(function(response) {
                modal.find('.modal-body').html(response);
                modal.modal('show');
            });
        }

        if ('accept' === method) {
            jqxhr.done(function(response) {
                highlightRow(id, response.result ? 'success' : 'warning');
                if (response.result) removeButtons(id);
            });
        }

        if ('decline' === method) {
            jqxhr.done(function(response) {
                highlightRow(id, response.result ? 'danger' : 'warning');
                if (response.result) removeButtons(id);
            });
        }

        event.preventDefault();
        return false;
    });

})(jQuery);