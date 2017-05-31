# Gendered Text

[![Circle CI](https://circleci.com/gh/markfullmer/porter2.svg?style=shield)](https://circleci.com/gh/markfullmer/gendered_text)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/markfullmer/gendered_text/master/LICENSE)

Dynamically rewrite the gender of personae in texts

![Screenshot of Conversion](https://github.com/markfullmer/gendered_text/raw/master/demo/demo.png)

## Background
Given a text with properly parameterized gender placeholders, this library will
generate an alternate version of the text based on user preference of gender. Gabriel García Márquez' first sentence,

> "Many years later, as he faced the firing squad, Colonel Aureliano Buendía was
> to remember that distant afternoon when his father took him to discover ice."

would become

> "Many years later, as she faced the firing squad, Colonel Aureliana Buendía was
> to remember that distant afternoon when her father took her to discover ice."

## Basic Usage
Text must have personae gender indicators entered as placeholder text, as well
as a legend that instructs the code which gender should be used for each
persona.

For example, original the *Hundred Years of Solitude* sentence, above, would need
to be entered as:

> Many years later, as {{ he(Aureliano Buendía) }} faced the firing squad,
> Colonel {{ Aureliano Buendía }} was to remember that distant afternoon when
> {{ his(Aureliano Buendía) }} father took {{ him(Aureliano Buendía) }} to
> discover ice.
>
> [[Aureliano Buendía/Aureliana Buendía:female]]

### The Legend
Text to be processed must include a legend, wrapped in double square brackets,
which may appear anywhere in the text. An example legend:

```[[Mindy/Mork:male][Charlize/Charles:female][Kate/Ken/Kan:trans]]```

Each element in the legend is wrapped in square brackets, and consists of the
gendered proper names for the character, in the order ```FEMALE/MALE/TRANS```.
This is followed by a colon, after which indicates the gender that should be used
in the dynamically generated version of the text.

So, using the legend above, the program will look for a character named "Mindy" or "Mork" and render this character as "Mork" with the male pronoun set. It will
look for a character named "Charlize" or "Charles" and render the character as
"Charlize" with the female pronoun set. It will look for a character named "Kate,"
"Ken" or "Kan," and render the character as "Kan" with a transgender pronoun.

### The Text
Text to be manipulated must include parameterized persona placeholders, wrapped
in double curly brackets. Examples:

```{{ She(Mindy) }}```
```{{ Mindy }}```
```{{ He(Mindy) }}```

Combined with the example legend, the below placeholder would render as follows:

| Placeholder | Rendered text |
| --- | --- |
| ```{{ She(Mindy) }}``` | He |
| ```{{ Mindy }}``` | Mork |
| ```{{ he(Mindy) }}``` | he |

In comparison, with the legend ```[[Mindy/Mork:female]]```, the same text would
render as:

| Placeholder | Rendered text |
| --- | --- |
| ```{{ She(Mindy) }}``` | She |
| ```{{ Mindy }}``` | Mindy |
| ```{{ he(Mindy) }}``` | she |

Example code implementation:

```php
$text = "{{ She(Mindy) }} sells seashells [[Mindy/Mork:male]]";
$result = GenderedText::process($text);
echo $text; // He sells seashells
```

### Callouts
An idiosyncrasy of English language pronouns is that, while the male possessive
pronoun "his" (as in "I like **his** shirt") is identical to the determinative
(as in "That shirt is **his**"), the female equivalents differ (i.e., "I like
**her** shirt" vs. "That shirt is **hers**"). Accordingly, male possessive
pronouns must be entered as "hisp" (e.g., ```I like {{ hisp(Mork) }} shirt```)
for differentiation from the determinative "his" (to avoid the result "I like
hers shirt").
