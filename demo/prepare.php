<?php

/**
 * @file
 * Demonstration file of the PHP Porter 2 English stemming algorithm.
 */

require '../vendor/autoload.php';
include 'header.php';
require_once 'config.php';
use markfullmer\gendered_text\GenderedText;

// Some default text.
$text = 'One midday when, after an absence of two hours, she came into the room, she beheld the chair empty. Down she flopped on the bed, and sitting, meditated. "Now where the devil is my man gone to!" she said.';

if (isset($_POST['text'])) {
  $text = $_POST['text'];
}

echo '
<div class="container">
  <form action="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '" method="POST">
    <div class="row">
      <div class="six columns">
        <label for="text">Paste original text with no placeholders.</label>
        <textarea class="u-full-width textbox" placeholder="Place words here..." name="text">' . $text . '</textarea>
      </div>
      <div class="six columns"><input class="button-primary" type="submit" name="json" value="Replace with placeholders" />';
if (isset($_POST['text'])) {
  echo '<p>' . nl2br(GenderedText::addPlaceholders($text)) . '</p>';
  echo '<div class="panel"><p>You have placeholder text! Now see how it can be
  genderized with a legend.</p><a href="test.php" class="button button-primary">Test ></a>';
}
echo '
      </div>
    </div>
  </form>';

include 'footer.php';
