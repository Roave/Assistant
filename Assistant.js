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
            self.trigger('endSpeak');
        };
        this.trigger('startSpeak');

        var speaking = true;

        speechSynthesis.speak(u);
        // Don't remove this console.log...
        // http://stackoverflow.com/questions/23483990/speechsynthesis-api-onend-callback-not-working#comment36226070_23483990
        console.log(u);
    };

    Module.prototype.passiveListen = function(triggerWord) {
        var self = this;
        recognition.onresult = function(event) {
            if (speaking) {
                // She doesn't like interruptions
                return;
            }

            for (var i = event.resultIndex; i < event.results.length; ++i) {
                var words = event.results[i][0].transcript;
                if (event.results[i].isFinal) {
                    console.log('Final: ' + words);
                    self.trigger('finalSpeech', [words])
                    return; // ignore the final, we use interim for low latency on the wake-up... maybe continue instead?
                } else if (!activelyListening) {
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
                        activelyListening = true;
                        self.on('finalSpeech', function() {
                            // once the rest of the speech from the trigger statement comes in, start active listening
                            self.on('finalSpeech', function(words) {
                                self.trigger('speechRequest', [words]);
                                activelyListening = false;
                                console.log('Going back into passive listening mode.');
                                return true;
                            });
                            console.log('Active listening mode enabled. Ready for request...');
                            return true;
                        });
                        self.speak('How can I help you?');
                    }
                    console.log('Interim: ' + words);
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
