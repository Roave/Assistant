(function ($, Donna) {
    Donna.on('startSpeak', function() {
        $('#status').text('Speaking');
    });
    Donna.on('endSpeak', function() {
        $('#status').text('Not Speaking');
    });
})($, Donna);
