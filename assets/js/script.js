jQuery(document).ready(function($) {

    // Click on trigger image to toggle event boxes
    $(document).on('click', '.event-trigger', function() {
        var targetId = $(this).data('target');
        var container = $('#' + targetId);
        
        // Toggle visibility with smooth animation
        if (container.hasClass('event-hidden')) {
            container.removeClass('event-hidden').addClass('event-visible');
        } else {
            container.removeClass('event-visible').addClass('event-hidden');
        }
    });

    // Collapse boxes when scrolled out of view
    $(window).on('scroll', function() {
        $('.event-wrapper').each(function() {
            var wrapper = $(this);
            var container = wrapper.find('.event-boxes-container');
            
            // Only check if boxes are currently visible
            if (container.hasClass('event-visible')) {
                var wrapperTop = wrapper.offset().top;
                var wrapperBottom = wrapperTop + wrapper.outerHeight();
                var scrollTop = $(window).scrollTop();
                var windowHeight = $(window).height();
                var windowBottom = scrollTop + windowHeight;
                
                // If wrapper is completely out of view (above or below), collapse it
                if (wrapperBottom < scrollTop || wrapperTop > windowBottom) {
                    container.removeClass('event-visible').addClass('event-hidden');
                }
            }
        });
    });

});
