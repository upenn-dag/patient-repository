// Init the side menu.
$(function() {
    $('#side-menu').menu();
});

// Loads the correct sidebar on window load,
// collapses the sidebar on window resize.
$(function() {
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
        $('input[type=date]').datepicker();
    }
});