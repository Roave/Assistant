'use strict';
(function (exports, EventEmitter) {

    function Module() {

    };

    Module.prototype = Object.create(EventEmitter.prototype);
    Module.prototype.constructor = Module;

    Module.prototype.command = function(command) {
        var self = this;
        self.trigger('commandReceived', [command.text]);
    };

    Module.prototype.respond = function(data) {
        var self = this;
        self.trigger('responseReceived', [data.text]);
    };

    Module.prototype.say = function(text) {
        return this.respond({'text': text});
    };

    exports.Assistant = Module;

})(window, EventEmitter);
