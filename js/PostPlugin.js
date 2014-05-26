'use strict';
(function (exports) {

    var Assistant;

    function Module(assistant, settings) {
        Assistant = assistant;
        settings = settings || {
            url: 'assistant.php',
        };

        Assistant.on('commandReceived', function(text) {
            $.post(settings.url, {'text': text}, function(data) {
                Assistant.respond({'text': data});
            });
        });
    };

    exports.PostPlugin = Module;
})(window);
