(function ($, Assistant) {
    Assistant.on('startSpeak', function() {
        $('#status').text('Speaking');
    });
    Assistant.on('endSpeak', function() {
        $('#status').text('Not Speaking');
    });
})($, Assistant);
