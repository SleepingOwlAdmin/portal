require('magnific-popup');

$('.image-link').magnificPopup({
    type: 'image',
    gallery: {
        enabled: true
    }
});

$('time').each(function() {
    var $self = $(this),
        value = $self.data('value') || $self.text();

    if (!value.length) return;

    $self.text(
        moment(value).format(
            $self.data('format') || window.settings.config.date.format
        )
    );
});
