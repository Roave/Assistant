## Plugin Architecture & Ideas

#### Response / Match Plugin

This type of plugin will listen for patterns like "what's the weather", "tell me the weather", "what's the weather like", "how hot is it outside", etc...

(Note: Google already matches all of those example weather queries with weather data...)

The plugin can then do anything it wants (call an external service, etc), and return a response to be given.

Plugins should be able to register themselves as the catch-all. Multiple catch-all's cascading should also be possible. For example: `wolframalpha -> no result -> chat bot -> response`

#### Notifier Plugin

A plugin that listens / monitors for something (new mail, calendar event, new SMS, etc?). When a new notification comes in, it will speak it immediately, or maybe make a small notification sound but queue them until the next time it hears the keyword?

#### Frontend / UI

A plugin should be able to provide their own JS / view template stuff to affect the page / UI. For example, "show me images of cats" might display a bunch of cat pictures on the page, or "play lumberjack song from youtube" would embed a youtube player right on the page.

The result coming back from the server should be able to specify something like:

```json
{
    "speak": "She will speak this text.",
    "jsfunction": "MyPlugin.process",
    "data": {
        "foo": "bar"
    },
    "stayActive": true
}
```

Or possibly use jsonp. The `stayActive` parameter would tell it to keep listening instead of going back into passive mode and waiting for the keyword.

Additionally, a frontend action might trigger something with a Chrome extension to do things like interact with Google Music, Gmail, etc.

### Plugin Ideas

- Static / easy match — simply uses some simple spreadsheet/csv to match/respond
- Youtube search
- Image / gif search
- [Site-specific search](http://stackoverflow.com/questions/14082568/how-to-let-google-detect-a-site-search-engine): "search amazon for usb hub"
- Weather
- Date/time
- Wolframalpha
- Phone notifications (via Pushbullet or similar)
- Chatbot (Pandorabots/ALICE/Cleverbot/etc)
- Google Now (as Chrome extension?)
- Google Play Music (as Chrome extension?)
- Android via Tasker / utter! / push notifications
  - Example: "Remind me to ______ in 20 minutes" could send a notification that's picked up by tasker and does it.
  - Example: "Read my last text message" could proxy to utter, which can handle that request. It would be a little weird because the response voice in this case would come from the phone, not the computer.
- Chromecast / Put.io
- Harvest / timetracking
- Multi-user messaging/reminders ("Tell Evan that Gary will not be available on Friday.") — this would just be a fun gimmick.
- Social: twitter, facebook
- Easter eggs, of course

### Integrations

- Hubot / IRC bot
- Hangouts (???)

### Misc Ideas

- Allow plugins to match sometimes (give a weight or something)... So you can ask the same question multiple times and get different responses.
- Allow "fuzzy" matching... this could be used as a first pass to reduce the total number of patterns we need to check against, or simply to find one. For example, a weather plugin could define a few keywords [weather, temperature, forecast] to help with discovery/matching instead of trying to match every possibly way someone might ask about the weather. (There are better machine learning and natural language parsing algorithms than this, but this would be a good, lazy way to start).

### Relevant Projects

- [Jasper](http://jasperproject.github.io/)
- [annyang](https://www.talater.com/annyang/)