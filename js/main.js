'use strict';

var assistant   = new Assistant;

var voicePlugin = new VoicePlugin(assistant, {
    keyword:  'assistant',
    response: 'How can I help you?'
});

var uiPlugin = new UIPlugin(voicePlugin);

var postPlugin  = new PostPlugin(assistant, {
    url: 'assistant.php'
});

assistant.say("Hello, I'm your virtual assistant.");
