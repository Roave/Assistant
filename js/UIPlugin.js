'use strict';
(function (exports, $) {
    var VoicePlugin;

    function Module(voicePlugin) {
        VoicePlugin = voicePlugin;

        VoicePlugin.on('startSpeak', function() {
            $('#status').text('Speaking');
        });
        VoicePlugin.on('endSpeak', function() {
            $('#status').text('Not Speaking');
        });
    };

    exports.UIPlugin = Module;
})(window, $);
