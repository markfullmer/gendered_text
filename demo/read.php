<?php

/**
 * @file
 * Demonstration file of the PHP Porter 2 English stemming algorithm.
 */

require '../vendor/autoload.php';
include 'header.php';
use markfullmer\gendered_text\GenderedText;

// Some default text.
$text = '{{ She(Mindy) }} sells seashells


[[Mindy:Mork:male]]';

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
  echo '<p>' . nl2br(GenderedText::process($text)) . '</p>';
}
echo '
      </div>
    </div>
  </form>
</div>';
include 'footer.php';
