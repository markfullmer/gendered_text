<?php

/**
 * @file
 * Demonstration file of the PHP Porter 2 English stemming algorithm.
 */

require '../vendor/autoload.php';
include 'header.php';
use markfullmer\gendered_text\GenderedText;
use markfullmer\gendered_text\Texts;

if (empty($_GET['text'])) {
  // Retrieve and display a list of available texts.
  echo '<div class="container"><div class="six columns"><label for="text">Choose a text:</label>';
  $texts = new Texts();
  $contents = $texts->getFolder('0BxeFmOHdUjWRbHBqM1kzLU9ES1k');
  asort($contents);
  foreach ($contents as $id => $title) {
    echo '<a href="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '?text=' . $id . '" class="button button-primary">' . $title . '</a><br />';
  }
  echo '</div>';
}
elseif (!empty($_GET['text']) && empty($_POST['characters'])) {
  // Allow the user to assign genders.
  $texts = new Texts();
  $text = $texts->getText($_GET['text']);
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
      $genders = ['male', 'female', 'trans'];
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
  $texts = new Texts();
  $text = $texts->getText($_GET['text']);
  if ($text) {
    $legend_string = GenderedText::findLegend($text);
    $text = GenderedText::removeLegend($text, $legend_string);
    $legend = GenderedText::buildLegend($_POST['characters']);
    echo '<div class="container">';
    echo '<a class="button" href="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '">Back to gender selector</a>';
    echo '<p>' . nl2br(GenderedText::process($text . $legend, '1-GUMdQ8iMpOUSz8PddPFZgf0YZZnPkAqPp8tuS5kMfI')) . '</p>';
    echo '</div>';
  }
}
include 'footer.php';
