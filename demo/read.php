<?php

/**
 * @file
 * Demonstration file of the PHP Porter 2 English stemming algorithm.
 */

require '../vendor/autoload.php';
include 'header.php';
use markfullmer\gendered_text\GenderedText;

if (empty($_GET['text'])) {
  echo '<div class="container"><div class="six columns"><label for="text">Choose a text to read:</label>';
  $dir = __DIR__ . '/texts/';
  $files = scandir($dir);
  foreach ($files as $file) {
    if (strpos($file, '.txt') !== FALSE) {
      $filename = str_replace('.txt', '', $file);
      echo '<a href="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '?text=' . $filename . '" class="button button-primary">' . $filename . '</a><br />';
    }
  }
  echo '</div>';
}
elseif (!empty($_GET['text']) && empty($_POST['characters'])) {
  $file = __DIR__ . '/texts/' . $_GET['text'] . '.txt';
  if (file_exists($file)) {
    $handle = @fopen($file, "r");
    $text = fread($handle, filesize($file));
    $legend_string = GenderedText::findLegend($text);
    $legend = GenderedText::parseLegend($legend_string);
    $set = [];
    $genders = ['male', 'female', 'trans'];
    echo '<div class="container">
    <form action="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '" method="POST">
      <div class="row">
        <div class="twelve columns">';
    echo '<h4>You will be reading ' . $_GET['text'] . '</h4>';
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
elseif (!empty($_GET['text']) && !empty($_POST['characters'])) {
  $file = __DIR__ . '/texts/' . $_GET['text'] . '.txt';
  if (file_exists($file)) {
    $handle = @fopen($file, "r");
    $text = fread($handle, filesize($file));
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
