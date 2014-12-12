// Loads the correct sidebar on window load,
// collapses the sidebar on window resize.
$(function() {
    $('#side-menu').menu();
    $(window).bind("load resize", function() {
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.sidebar-collapse').addClass('collapse');
        } else {
            $('div.sidebar-collapse').removeClass('collapse');
        }
    });
});

// Initialize the bootstrap picker if required.
$(function() {
    if (!Modernizr.inputtypes.date) {
        $('input[type=date]').attr('type', 'text').datepicker({ format: 'yyyy-mm-dd' });
    }
});

// Intercept the search button and direct to proper search page.
$(function() {
    searchUrl = Accard.get('current_url').clone();
    if (searchUrl.isDev()) {
        searchUrl.segments = ['app_dev.php', 'search'];
    } else {
        searchUrl.segments = ['search'];
    }

    var search = function(event) {
        var val = $('#accard-search-field').val();
        if (val) {
            searchUrl.addParam('q', val);
        }

        searchUrl.replace();
    }

    $('#accard-search').on('click', search);
    $('#accard-search-field').on('keypress', function(event) {
        if (event.which == 13) {
            search.call(event);
        }
    });
});