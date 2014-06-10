# Plugin Architecture

This is a proposed plugin architecture for the RoaveAssistant framework that leverages the ZF2 module system.

### Filters

A plugin can provide one or more filters to run the input text through. For example, you may want to strip periods, strtolower, etc (those examples would probably be in the core, but you can easily provide additionals). Also, these filters could handle things like stemming and simplifying/normalizing the input (you're => you are, cause => because, etc).

### Intents

An `intent` is some name / tag for a recognized input to the system. For example, the input, `My name is Evan.` would match the `set_name` intent, while the input, `What is my name?` would match the `get_name` intent.

A particular input can match zero or more intents.


Plugins can provide intents two different ways:

#### 1. Simple Config Intent

If a plugin (zf2 module) returns a config with the `roave_assistant_intents` key, the defined intents will be automatically registered.

For example:

```php
<?php
namespace Roave\Assistant\NamePlugin;

class Module
{
    protected $config = [
        'roave_assistant_intents' => [
            'set_name' => [
                'expressions' => [
                    'my name is {@name}',
                    'call me {@name}',
                ],
            ],
            'get_name' => [
                'expressions' => [
                    'what is my name'
                ],
            ],
        ],

    ];

    public function getConfig()
    {
        return $this->config;
    }
}
```

#### 2. Custom Code Intent

If you have more complex matching logic than a simple regular expression, you can define your own custom intent.

```php
<?php
namespace Roave\Assistant\NamePlugin;

use Roave\Assistant\Intent;

class SetNameIntent extends Intent
{
    public function match($string)
    {
        $match = $witAiClient->match($string);
        if ($match) {
            $this->setName($match->name);
            return true;
        }

        return false;
    }
}
```

(It still needs to be worked out how these custom intents get registered, probably using the IntentListener somehow.)

### Expression String Variables

When defining expressions for an intent to match, you can put placeholder parameters. There are a couple different ways you can do this.

* `my name is {@user.name}` — a variable with the @ prefix indicates that the value given should be automatically stored in the brain. The user prefix indicates that this variable should be stored in a user-specific namespace.
* `your name is {@global.name}` — same thing, except this time the value will be stored in the brain's global namespace.
* `weather in {:city}` — simple expression parameter. is not persisted anywhere, but is availble to responders and to be referenced in the response string

### Response String Variables

* `your name is {@user.name}` — pulls value from the brain's user-specific namespace.
* `my name is {@global.name}` — pulls value from the brain's global namespace.
* `the weather is nice in {:city} right now` — The :variable syntax simply populates the value for this key that was matched by the intent expression.

### Responders

A responder looks at the matched intent(s) and decides how to react and if it should set/ammend/prepend the response. For performance reasons, responders may be dynamically attached only when certain intents are matched.

### Brain

The brain is:

* A simple key/value storage
* There should be two areas/namepaces for the brain: user-specific, and global. All user can have a different value stored for a single user-specific brain key. For example, this allows the bot to know what to call each user, or the gender of each user or whatever else.
* Modules / plugins can provide brain key/value pairs as overrides (always used) or fallbacks (only used if no specific value already exists.
