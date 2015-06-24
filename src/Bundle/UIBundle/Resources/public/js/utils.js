;(function($) {

  function inIframe() {
    try {
      return window.self !== window.top;
    } catch (e) {
      return true;
    }
  }

  function getAccardClient() {
    return window.accardClient;
  }

  function hasAccardClient() {
    return !!window.accardClient;
  }

  function getAccardCallback() {
    return window.accardCallback;
  }

  function hasAccardCallback() {
    return !!window.accardCallback;
  }

  function reloadThisWindow() {
    window.location.reload();
  }

  $('body').on('click', '[data-accard=modal]', function(e) {
    if (hasAccardClient()) {
      e.preventDefault();
      getAccardClient().send('modal', {
        url: $(this).attr('href'),
        onHide: 'reload'
      });
    }
  });

  window.hasAccardClient = hasAccardClient;
  window.getAccardClient = getAccardClient;

  // Handle has changes and auto-hash reloading. We use push state, to avoid
  // content jumping and to later handle app url relocation.
  if (0 < $('.nav-tabs a').length) {
    var url = document.location.toString();
    
    document.body.scrollTop = 0;

    if (url.match('#')) {
      $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show');
    } 
    
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
      if (history.pushState) {
        history.pushState(null, null, e.target.hash);
      } else {
        window.location.hash = e.target.hash;
      }
    });
  }
  
  function _handleConfirm(e) {
    var message = $(this).data('confirm') || 'Are you sure?';
    var confirm = window.confirm(message);

    if (!confirm) {
      e.preventDefault();
      e.stopPropagation();
    }

    return confirm;
  }

  // Confirmation button intervention.
  $('body').on('click', '[data-accard=confirm]', _handleConfirm);

  // Delete form intervention.
  $('body').on('submit', 'form[data-accard=formdelete]', function(e) {
    var confirm = _handleConfirm.bind(this)(e);

    if (!confirm) return;

    e.preventDefault();
    e.stopPropagation();

    var jqxhr = $.ajax({
      type: 'POST',
      url: $(this).attr('action'),
      data: $(this).serialize()
    })
      .done(function() {
        window.location.reload();
      })
      .fail(function() {
        alert('Unable to delete resource, please try again later.');
      })
    ;
  });

  // Prototype filtering
  $('body').on('click', 'table [data-accard="prototype-activator"]', function(e) {
    var $this = $(this);
    var $table = $this.closest('table');

    if (!$table) return;

    $table.find('tbody[data-accard=prototypes]').toggle();
    $this.find('.caret').toggleClass('caret-reversed')
    $this.blur();
  });

  $('tbody[data-accard=prototypes]').on('change', 'input[type=radio]', function(e) {
    var $this = $(this);
    var $table = $this.closest('table');

    if (!$table) return;

    var prototype = $this.data('accard');
    var $list = $table.find('tr[data-accard-activity]');

    $list.filter('[data-accard-activity="' + prototype + '"]').show();
    $list.not('[data-accard-activity="' + prototype + '"]').hide();
  });

})(window.jQuery);
