'use strict';
(function (exports, $) {

    function Module(voicePlugin) {
        var voicePlugin = voicePlugin;

        voicePlugin.on('startSpeak', function() {
            $('#status').text('Speaking');
        });
        voicePlugin.on('endSpeak', function() {
            $('#status').text('Not Speaking');
        });
    };

    exports.UIPlugin = Module;
})(window, $);
