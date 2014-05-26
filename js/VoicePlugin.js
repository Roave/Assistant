'use strict';
(function (exports, EventEmitter) {

    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.interimResults = true;

    var speaking = false;
    var activelyListening = false;
    var Assistant;

    function Module(assistant, settings) {
        var self = this;
        Assistant = assistant;

        Assistant.on('responseReceived', function(text) {
            self.speak(text);
        });

        settings = settings || {
            keyword:  'assistant',
            response: 'How can I help you?'
        };

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
                    //self.trigger('interimSpeech', [words]);
                    if (words.match(new RegExp(settings.keyword, 'i'))) {
                        /**
                         * They just said the trigger word. Now, the next time
                         * final speech results come back, will be for the
                         * entire 'wake up' statement, like 'wake up
                         * assistant'. When that happens, we enter active
                         * listening mode, and the next 'final' speech result
                         * that comes back will trigger a speech request.
                         */
                        self.speak(settings.response);
                        activelyListening = true;
                        console.log('Active listening mode enabled. Ready for request...');
                        self.on('finalSpeech', function(text) {
                            Assistant.command({'text': text});
                            //self.trigger('speechRequest', [words]);
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

    Module.prototype = Object.create(EventEmitter.prototype);
    Module.prototype.constructor = Module;

    /**
     * Chrome has a bug with passing long text to the speech synthesizer that causes it to freeze.
     * Author: Peter Woolley http://stackoverflow.com/questions/21947730/chrome-speech-synthesis-with-longer-texts
     */
    var speechUtteranceChunker = function (utt, settings, callback) {
        settings = settings || {};
        var chunkLength = settings && settings.chunkLength || 160;
        var pattRegex = new RegExp('^.{' + Math.floor(chunkLength / 2) + ',' + chunkLength + '}[\.\!\?\,]{1}|^.{1,' + chunkLength + '}$|^.{1,' + chunkLength + '} ');
        var txt = (settings && settings.offset !== undefined ? utt.text.substring(settings.offset) : utt.text);
        var chunkArr = txt.match(pattRegex);

        if (chunkArr[0] !== undefined && chunkArr[0].length > 2) {
            var chunk = chunkArr[0];
            var newUtt = new SpeechSynthesisUtterance(chunk);
            var x;
            for (x in utt) {
                if (utt.hasOwnProperty(x) && x !== 'text') {
                    newUtt[x] = utt[x];
                }
            }
            newUtt.onend = function () {
                settings.offset = settings.offset || 0;
                settings.offset += chunk.length - 1;
                speechUtteranceChunker(utt, settings, callback);
            }
            console.log(newUtt); //IMPORTANT!! Do not remove: Logging the object out fixes some onend firing issues.
            //placing the speak invocation inside a callback fixes ordering and onend issues.
            setTimeout(function () {
                speechSynthesis.speak(newUtt);
            }, 0);
        } else {
            //call once all text has been spoken...
            if (callback !== undefined) {
                callback();
            }
        }
    };

    Module.prototype.speak = function(text) {
        var self = this;
        var u = new SpeechSynthesisUtterance(text);
        speaking = true;
        recognition.stop();
        console.log('Speaking started.');
        this.trigger('startSpeak');
        // Possible fallback: http://translate.google.com/translate_tts?tl=en&q=speech+to+convert
        speechUtteranceChunker(u, {chunkLength: 140}, function() {
            console.log('Speaking ended.');
            speaking = false;
            recognition.start();
            self.trigger('endSpeak');
        });
    };


    exports.VoicePlugin = Module;

})(window, EventEmitter);
