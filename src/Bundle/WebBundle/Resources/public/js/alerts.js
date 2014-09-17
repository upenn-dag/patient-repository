;(function($) {

    var fadeTime = 4500;
    var animateOut = function(alert) {
        $(alert)
            .animate({height: '+=10'}, 185)
            .slideUp(500, function() { $(this).alert('close'); });
    }

    $("body > .alert")
        .fadeTo(1, 0.9)
        .fadeTo(fadeTime, 0.8, function() {
            animateOut(this);
        })
        .on('mouseover', function() {
            $(this).fadeTo(1, 0.9).stop(true, false);
        })
        .on('mouseout', function() {
            $(this).fadeTo(fadeTime/2, 0.9, function() {
                animateOut(this);
            });
        })

})(window.jQuery);