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

});
