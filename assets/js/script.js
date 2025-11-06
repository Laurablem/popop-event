jQuery(document).ready(function($) {

    // Når man klikker på triggerbilledet/eventillustrationen, åbnes eller lukkes eventboksene
    $(document).on('click', '.event-trigger', function() {
        var targetId = $(this).data('target');
        var container = $('#' + targetId);
        
        // Toggler mellem synlig og skjult med en glidende animation
        if (container.hasClass('event-hidden')) {
            container.removeClass('event-hidden').addClass('event-visible');
        } else {
            container.removeClass('event-visible').addClass('event-hidden');
        }
    });

    // Lukker eventboksene automatisk, når man scroller væk fra sektionen
    $(window).on('scroll', function() {
        $('.event-wrapper').each(function() {
            var wrapper = $(this);
            var container = wrapper.find('.event-boxes-container');
            
            // Kører kun, hvis eventboksene er åbne. Bruges til at tjekke, om de skal lukkes ved scroll
            if (container.hasClass('event-visible')) {
                var wrapperTop = wrapper.offset().top;
                var wrapperBottom = wrapperTop + wrapper.outerHeight();
                var scrollTop = $(window).scrollTop();
                var windowHeight = $(window).height();
                var windowBottom = scrollTop + windowHeight;
                
                // Lukker eventboksene automatisk, når sektionen ikke længere er synlig på skærmen (uden for viewport)
                if (wrapperBottom < scrollTop || wrapperTop > windowBottom) {
                    container.removeClass('event-visible').addClass('event-hidden');
                }
            }
        });
    });

});
