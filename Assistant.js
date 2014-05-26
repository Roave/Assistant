(function (exports, EventEmitter) {
    'use strict';

    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.interimResults = true;

    var passiveListening = false;

    function Module() {

    };

    Module.prototype = Object.create(EventEmitter.prototype);
    Module.prototype.constructor = Module;

    Module.prototype.speak = function(text, callback) {
        var self = this;
        var u   = new SpeechSynthesisUtterance();
        u.text  = text;
        u.onend = function(e) {
            passiveListening = true;
            self.trigger('endSpeak');
        };
        this.trigger('startSpeak');
        passiveListening = false;
        speechSynthesis.speak(u);
        // Don't remove this console.log...
        // http://stackoverflow.com/questions/23483990/speechsynthesis-api-onend-callback-not-working#comment36226070_23483990
        console.log(u);
    };

    Module.prototype.passiveListen = function(triggerWord) {
        var self = this;
        recognition.onresult = function(event) {
            if (!passiveListening) {
                return;
            }
            for (var i = event.resultIndex; i < event.results.length; ++i) {
                var word = event.results[i][0].transcript;
                if (event.results[i].isFinal) {
                    console.log('Final: ' + word);
                    return; // ignore the final, we use interim for low latency on the wake-up
                } else {
                    console.log('Interim: ' + word);
                }
                if (passiveListening && word.match(new RegExp(triggerWord, 'i'))) {
                    passiveListening = false;
                    self.trigger('passiveMatch');
                    self.speak('How can I help you?');
                }
            }
        };
        recognition.onend = function() {
            // always listening... Chrome times out after 60 seconds.
            recognition.start();
        };
        recognition.start();

    };

    exports.Assistant = new Module;

})(window, EventEmitter);
