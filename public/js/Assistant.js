'use strict';
(function (exports, EventEmitter) {

    function Module() {

    };

    Module.prototype = Object.create(EventEmitter.prototype);
    Module.prototype.constructor = Module;

    Module.prototype.command = function(command) {
        this.trigger('commandReceived', [command.text]);
    };

    Module.prototype.respond = function(data) {
        this.trigger('responseReceived', [data.text]);
    };

    Module.prototype.say = function(text) {
        return this.respond({'text': text});
    };

    exports.Assistant = Module;

})(window, EventEmitter);
