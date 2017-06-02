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
        <label for="text">Original text with no placeholders.</label>
        <textarea class="u-full-width textbox" placeholder="Place words here..." name="text">' . $text . '</textarea>
      </div>
      <div class="six columns"><input type="submit" name="json" value="Replace with placeholders" />';
if (isset($_POST['text'])) {
  echo '<p>' . nl2br(GenderedText::addPlaceholders($text)) . '</p>';
}
echo '
      </div>
    </div>
  </form>
</div>
</body>
</html>';
