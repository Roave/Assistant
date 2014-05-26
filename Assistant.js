(function (exports, EventEmitter) {
    'use strict';

    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.interimResults = true;

    var speaking = false;
    var activelyListening = false;

    function Module() {

    };

    Module.prototype = Object.create(EventEmitter.prototype);
    Module.prototype.constructor = Module;

    Module.prototype.speak = function(text, callback) {
        var self = this;
        var u   = new SpeechSynthesisUtterance();
        u.text  = text;
        u.onend = function(e) {
            speaking = false;
            recognition.start();
            self.trigger('endSpeak');
        };
        this.trigger('startSpeak');

        speaking = true;
        recognition.stop();

        speechSynthesis.speak(u);
        // Don't remove this console.log...
        // http://stackoverflow.com/questions/23483990/speechsynthesis-api-onend-callback-not-working#comment36226070_23483990
        console.log(u);
    };

    Module.prototype.passiveListen = function(triggerWord) {
        var self = this;
        recognition.onresult = function(event) {
            if (speaking) {
                // She doesn't like interruptions (and we don't want her to hear herself)
                return;
            }

            for (var i = event.resultIndex; i < event.results.length; ++i) {
                var words = event.results[i][0].transcript;
                if (event.results[i].isFinal) {
                    console.log('Final: ' + words);
                    self.trigger('finalSpeech', [words])
                    return; // ignore the final, we use interim for low latency on the wake-up... maybe continue instead?
                } else if (!activelyListening) {
                    console.log('Interim: ' + words);
                    self.trigger('interimSpeech', [words]);
                    if (words.match(new RegExp(triggerWord, 'i'))) {
                        /**
                         * They just said the trigger word. Now, the next time
                         * final speech results come back, will be for the
                         * entire 'wake up' statement, like 'wake up
                         * assistant'. When that happens, we enter active
                         * listening mode, and the next 'final' speech result
                         * that comes back will trigger a speech request.
                         */
                        self.speak('How can I help you?');
                        activelyListening = true;
                        console.log('Active listening mode enabled. Ready for request...');
                        self.on('finalSpeech', function(words) {
                            self.trigger('speechRequest', [words]);
                            activelyListening = false;
                            console.log('Going back into passive listening mode.');
                            return true;
                        });

                        return; // if we matched, let's stop going through the results
                    }
                }
            }
        };
        recognition.onend = function() {
            // always listening... Chrome times out after 60 seconds.
            if (!speaking) {
                console.log('Timeout. Restarted speech recognition.');
                recognition.start();
            }
        };
        //recognition.start();

    };

    exports.Assistant = new Module;

})(window, EventEmitter);
