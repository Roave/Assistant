# Input / Expression Handling

- Input filters: stemming, strtolower, other normalization
- Variable parsing: parse out @var and :var variables
- Trigger event
    - Many plugins can just listen and process input but not affect the response.
    - Many plugins can provide intents but not handle responses.
    - Plugin(s) can set, append, or prepend the response, kindof like headTitle()
    - Plugin can short-circuit response.
    - Could use event identifiers for keyword-sensitive listeners/plugins

- Possibly make @previousUserName variable available for more dynamic responses. "Okay, I'll call you master instead of Evan"
- Brain historic values (bonus if timestamp data)
- wit.ai plugin

- Plugin Ideas:
    - Plugin manager plugin. "Enable the names plugin", "Disable the names plugin", "What plugins are enabled?"
    - Name plugin... Set name(s) for user and such

- variable/placeholder types / specific parser

- installer cli mode to import knowledge and shit
- Allow plugin to set "context key", and on next request, a context event is triggered wit hthat key as an identifier, allowing for contextual back/forth
    - Abstract this concept so it works on a long-running CLI process or via sessions in browser

TODO:
- Response handling in intent
- Expression parsing
- Type plugins / parsing on expressions
- Response parse $variable pre-interpolation
- Response brain @variable interpolation
- Response input :variable interpolation

------

Learning module:

> learn
< What's the intent?
> set name
< New intent created: set name
> Your name is Donna.
< Which word is an entity?
> Donna is a name
> What's 
> My name is Evan.

> Your name is Donna.
< ???
> Donna is a name.
(Your name is :name)
self-name = Donna
---
Names Module:

- Recognizes names of things and relations
- Recognizes the user's name
- Recognizes names/relations relative to the user


Recognizing the user's name:

[intent: set name]

> I'm Evan
> Call me Evan
> My name['s|is] Evan

[intent: ask name]
> What's my name?
> What is my name?
> What do you call me?
> [What did|What'd] I tell you my name was?
> [What did|What'd] I tell you my name is?
> What'd I tell you my name is?
> What'd I tell you my name was?

(Or any high confidence fuzzy search match)

> My girlfriend's name is Alissa.

> Evan's girlfriend's name is Alissa.
search for Evan, no result:
> Who is Evan?
< My brother
< I am
< Me
< Evan is my brother.
< I am Evan.
< Evan is me.
< He's my brother.

> Do you want me to call you Evan?



