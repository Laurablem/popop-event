jQuery(document).ready(function($) {

  // Klik på trigger-billedet
  $(document).on('click', '.popup-event-trigger', function() {
    var targetId = $(this).data('popup-target');
    $('#' + targetId).removeClass('popup-hidden');
  });

  // Klik på luk-knappen
  $(document).on('click', '.popup-close', function() {
    $(this).closest('.popup-event-overlay').addClass('popup-hidden');
  });

  // Klik på mørk baggrund (overlay) lukker også
  $(document).on('click', '.popup-event-overlay', function(e) {
    if ($(e.target).is('.popup-event-overlay')) {
      $(this).addClass('popup-hidden');
    }
  });

});
