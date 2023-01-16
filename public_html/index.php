<?php

/**
 * @file
 * Demonstration file of the PHP Porter 2 English stemming algorithm.
 */

require '../vendor/autoload.php';

include 'header.php';
use markfullmer\gendered_text\GenderedText;

if (empty($_GET['text'])) {
  // Retrieve and display a list of available texts.
  echo '<div class="container"><div class="six columns"><label for="text">Choose a text:</label>';
  $directory = 'texts';
  $texts = array_diff(scandir($directory), array('..', '.'));
  asort($texts);
  foreach ($texts as $filename) {
    $parts = explode('.', $filename);
    echo '<a href="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '?text=' . $filename . '" class="button button-primary">' . $parts[0] . ': ' . $parts[1] . '</a><br />';
  }
  echo '</div>';
}
elseif (!empty($_GET['text']) && empty($_POST['characters'])) {
  // Allow the user to assign genders.
  $text = file_get_contents('texts/' . $_GET['text']);
  if ($text) {
    $legend_string = GenderedText::findLegend($text);
    $legend = GenderedText::parseLegend($legend_string);
    if (empty($legend)) {
      echo '<h4>This text does not appear to have a character legend. The code
      cannot proceed.</h4>';
    }
    else {
      $set = [];
      echo '<div class="container">
      <form action="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '" method="POST">
        <div class="row">
          <div class="twelve columns">';
      $genders = ['male', 'female', 'non-binary'];
      foreach ($legend as $key => $values) {
        if ($key != 'names') {
          $list = implode('/', $values['names']);
          if (!in_array($list, $set)) {
            echo '<label for="characters[' . $list . ']">Gender for "' . $list . '": ';
            echo '<select name="characters[' . $list . ']">';
            foreach ($genders as $gender) {
              echo '<option value="' . $gender . '"';
              if ($gender == $values['gender']) {
                echo ' selected="selected"';
              }
              echo '>' . ucfirst($gender) . '</option>';
            }
            echo '<option value="random">Surprise me!</option>';
            echo '</select>';
            $set[] = $list;
          }
        }
      }
      echo '<br /><input class="button button-primary" type="submit" name="submit" value="Read the text" />';
      echo '
            </div>
          </div>
        </form>
      </div>';
    }
  }

}
elseif (!empty($_GET['text']) && !empty($_POST['characters'])) {
  // Display the text!
  $text = file_get_contents('texts/' . $_GET['text']);
  if ($text) {
    $legend_string = GenderedText::findLegend($text);
    $text = GenderedText::removeLegend($text, $legend_string);
    $legend = GenderedText::buildLegend($_POST['characters']);
    echo '<div class="container">';
    echo '<a class="button" href="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '">Back to gender selector</a>';
    echo '<p>' . nl2br(GenderedText::process($text . $legend)) . '</p>';
    echo '</div>';
  }
}
include 'footer.php';
