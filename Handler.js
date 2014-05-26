(function (Assistant) {
    Assistant.on('speechRequest', function(words) {
        Assistant.speak('I heard, ' + words);
    });
})(Assistant);
