# Gendered Lit

[![Circle CI](https://circleci.com/gh/markfullmer/porter2.svg?style=shield)](https://circleci.com/gh/markfullmer/gendered_lit)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/markfullmer/gendered_lit/master/LICENSE)

Dynamically rewrite the gender of personae in texts

![Screenshot of Conversion](https://raw.githubusercontent.com/markfullmer/gendered_lit/master/demo/demo.png)

## Background
Given a text with properly parameterized gender placeholders, this library will
generate an alternate version of the text based on user preference of gender. Gabriel Garcia Marquez' "Many years later, as he faced the firing squad, Colonel Aureliano Buendía was to remember that distant afternoon when his father took him to discover ice." will become "Many years later, as she faced the firing squad, Colonel Aureliana Buendía was to remember that distant afternoon when her father took her to discover ice."

## Basic Usage
The included `/demo/index.php` file contains a conversion form demonstration.

Make your code aware of the `GenderedLit` class via your favorite method (e.g.,
`use` or `require`)

Two simple methods, "male" and "female" are available, and can be used as such:
```php
$text = GenderedLit::male("She sells seashells.");
echo $text; // He sells seashells.

$text = GenderedLit::female("He sells seashells.");
echo $text; // She sells seashells.
```

However, these are really helper methods for the main "process" method, described
next.

### The Legend
Text to be processed must include a legend, wrapped in double square brackets, which may appear anywhere in the text. An example legend:

```[[Mindy/Mork:male][Charlize/Charles:female][Kate/Ken/Kan:trans]]``
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

$text = "{{ She(Mindy) }} sells seashells [[Mindy:Mork:male]]";
$result = GenderedLit::process($text);
echo $text; // He sells seashells
```
