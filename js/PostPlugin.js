'use strict';
(function (exports) {

    function Module(assistant, settings) {
        var assistant = assistant;
        var settings = settings || {
            url: 'assistant.php',
        };

        assistant.on('commandReceived', function(text) {
            $.post(settings.url, {'text': text}, function(data) {
                assistant.respond({'text': data});
            });
        });
    };

    exports.PostPlugin = Module;
})(window);
