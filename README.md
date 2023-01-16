# Gendered Text

[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/markfullmer/gendered_text/master/LICENSE)

About
=====

> [George Orwell](https://www.goodreads.com/book/show/6324725-politics-and-the-english-language) once argued that clichéd language produces clichéd thinking. So let's change the language.

**Purpose:**

1.  Dynamically rewrite the gender of personae in texts
2.  Challenge unconscious biases about gender and characters

**Background:** Unconscious biases on characters' gender continue in narrative fiction, both in print and on screen. Although, [studies show](https://www.nytimes.com/2018/12/11/movies/creative-artists-agency-study.html) that movies with women in leading roles and movies that pass the Bechdel test are more profitable, most roles, leading and otherwise, still go to men. Women fill less than a third of speaking roles in film, according to a [review of the 700 top-grossing films from 2007 to 2014](http://annenberg.usc.edu/pages/~/media/MDSCI/Inequality%20in%20700%20Popular%20Films%208215%20Final%20for%20Posting.ashx) conducted by the University of Southern California. Men get more speaking time in ads, according the [Gina Davis Institute's 2017 study](https://seejane.org/research-informs-empowers/gender-bias-advertising/). In most [Disney princess films](https://www.washingtonpost.com/news/wonk/wp/2016/01/25/researchers-have-discovered-a-major-problem-with-the-little-mermaid-and-other-disney-movies/?utm_term=.e06e4affd05e/), the amount of time women get to talk or act is overshadowed by the male characters. Research has shown similar gender imbalances in literature - from [children's stories](https://seejane.org/research-informs-empowers/gender-bias-advertising/), to [award-winning literary fiction](https://nicolagriffith.com/2015/05/26/books-about-women-tend-not-to-win-awards/), to [best selling genres](http://www.huffingtonpost.com/entry/women-writers-face-major-hurdles-especially-in-bestselling-genres_us_592dd993e4b055a197cde4ff) like sci-fi and fantasy. Not to mention the [challenges faced by female authors](http://www.vidaweb.org/the-2015-vida-count/) in getting published.

**Method:** The gendered text project is an open source website allowing users to radically alter the gender of characters in a story. Users can read selected texts already modified for this format or submit their own texts. To modify a text this project, first [input a text](https://genderedtextproject.com/prepare) to identify all the gendered nouns in a story. Then, manually tag each gendered noun with the associated character. Insert a [legend](https://genderedtextproject.com/legends) with a list of characters and alternate names. Finally, choose a gender for each character to [output](https://genderedtextproject.com/test) a new, revised text.

**Examples:** Changing a character's gender changes the story in multiple ways. 

What makes a hero? Imagine Conan the Barbarian (a man) as Cuzha the Barbarian (a woman). The character remains an unparalleled warrior, adventuring in exotic lands and soundly defeating all foes, but as a woman instead of a man. 

What makes a villain? Changing the gender may change a character from a hero to a villain or versa. Take the Queen of Hearts from Alice in Wonderland. Instead of a paranoid, hysterical shrew screaming "Off with their heads" every other line, as a man, the character becomes a ruthless tyrant, a bloodthirsty dictator, someone to be taken seriously. 

Changing gender may also change sexual orientation. Take the example of Conan again. The character often takes a lover who fights by the barbarian's side in life and in death. What if it was Cuzha who seduces the Queen of the Black Coast or Conan who takes the King as a lover? A character's gender does not just reflect on that one character, but the whole story.

![Screenshot of Conversion](https://github.com/markfullmer/gendered_text/raw/master/demo/demo.png)

## Purpose
Given a text with properly parameterized gender placeholders, this library will
generate an alternate version of the text based on user preference of gender. Gabriel García Márquez' first sentence,

> Many years later, as he faced the firing squad, Colonel Aureliano Buendía was
> to remember that distant afternoon when his father took him to discover ice.

would become

> Many years later, as she faced the firing squad, Colonel Aureliana Buendía was
> to remember that distant afternoon when her father took her to discover ice.

## Try the Demo
Visit [https://gendered-text.markfullmer.com/demo/](https://gendered-text.markfullmer.com/demo/) to see a demonstration.

## Creating your own texts

### 0. The Word Map
Review the full list of [currently available gender mappings in the code](https://github.com/markfullmer/gendered_text/blob/master/src/WordMap.php)

### 1. Add Placeholders
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
> [[Aureliana Buendía/Aureliano Buendía:female]]

In order to render as male-gendered, the text could be entered as:

> Many years later, as {{ she(Aureliano Buendía) }} faced the firing squad,
> Colonel {{ Aureliano Buendía }} was to remember that distant afternoon when
> {{ herd(Aureliano Buendía) }} father took {{ her(Aureliano Buendía) }} to
> discover ice.
> [[Aureliana Buendía/Aureliano Buendía:male]]

** Note the use of "herd" to differentiate determiner & object. See **Callouts**,
below.

### 1a. Texts with multiple personae
The sentence from D.H Lawrence's *Sons and Lovers*, "He kept her because he never satisfied her", illustrates two personae
working in tandem. The text would be parameterized as:

> {{ He(Paul) }} kept {{ her(Clara) }} because {{ he(Paul) }} never
> satisfied {{ her(Clara) }}.

Adding the legend ``` [[Paulina/Paul:male][Clara/Clark:female]]``` would generate
 the original text, while ```[[Paulina/Paul:female][Clara/Clark:male]]``` would
 reverse the roles:

> She kept him because she never satisfied him.

and ```[[Paulina/Paul:male][Clara/Clark:male]]``` would generate:

> He kept him because he never satisfied him.

### 2. Create the Legend
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

### Expected results
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
- An idiosyncrasy of English language pronouns is that, while the male possessive
pronoun "his" (as in "I like **his** shirt") is identical to the determinative
(as in "That shirt is **his**"), the female equivalents differ (i.e., "I like
**her** shirt" vs. "That shirt is **hers**"). Accordingly, male determinative
pronouns must be entered as "hisd" (e.g., ```That shirt is {{ hisd(Mork) }}```)
for differentiation from the possessive "his" (to avoid the result "I like
hers shirt").
- Similarly, the female determiner ("I like **her** hairdo") is identical to the
female object ("I like **her**"), but the male forms differ ("I like **his** hairo" vs.
"I like **him**"). Therefore, the female determiner must be identified as "herd".
