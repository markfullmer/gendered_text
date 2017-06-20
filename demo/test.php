<?php

/**
 * @file
 * Demonstration file of the PHP Porter 2 English stemming algorithm.
 */

require '../vendor/autoload.php';
include 'header.php';
use markfullmer\gendered_text\GenderedText;

// Some default text.
$text = 'One midday when, after an absence of two hours, {{ Arabella }} came into the room, {{ she(Arabella) }} beheld the chair empty. Down {{ she(Arabella) }} flopped on the bed, and sitting, meditated. "Now where the devil is my {{ man(Jude) }} gone to!" {{ she(Arabella) }} said.

[ [Arabella/Arthur/Aspen:male] [Julie/Jude/Juen:female] ]';

if (isset($_POST['text'])) {
  $text = $_POST['text'];
}

echo '
<div class="container">
  <form action="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '" method="POST">
    <div class="row">
      <div class="six columns">
        <label for="text">Text to be genderized. See <a href="https://github.com/markfullmer/gendered_lit/blob/master/README.md">examples of required text elements.</a></label>
        <textarea class="u-full-width textbox" placeholder="Place words here..." name="text">' . $text . '</textarea>
      </div>
      <div class="six columns"><input type="submit" name="json" value="Genderize" />';
if (isset($_POST['text'])) {
  echo '<p>' . nl2br(GenderedText::process($text, WORDMAP_SHEET_ID)) . '</p>';
  echo '<div class="panel"><p>The legend allows manual switching of genders. Now let the reader choose!</p><a href="read.php" class="button button-primary">Read ></a>';
}
echo '
      </div>
    </div>
  </form>
</div>';
include 'footer.php';
