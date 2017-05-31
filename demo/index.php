<?php

/**
 * @file
 * Demonstration file of the PHP Porter 2 English stemming algorithm.
 */

require '../vendor/autoload.php';

use markfullmer\gendered_text\GenderedText;

// Some default text.
$text = '{{ She(Mindy) }} sells seashells


[[Mindy:Mork:male]]';

if (isset($_POST['text'])) {
  $text = $_POST['text'];
}
echo '<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">
</head>
<body>';

echo '
<div class="container">
  <form action="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '" method="POST">
    <div class="row">
      <div class="six columns">
        <label for="text">Text to be genderized. See <a href="https://github.com/markfullmer/gendered_lit/blob/master/README.md">examples of required text elements.</a></label>
        <textarea class="u-full-width textbox" placeholder="Place words here..." name="text">' . $text . '</textarea>
      </div>
      <div class="six columns"><input type="submit" name="json" value="Transform" />';
if (isset($_POST['text'])) {
  $start = microtime(TRUE);
  echo '<p>' . GenderedText::process($text) . '</p>';
  echo (microtime(TRUE) - $start) . ' seconds to complete operation.';
}
echo '
      </div>
    </div>
  </form>
</div>
</body>
</html>';
