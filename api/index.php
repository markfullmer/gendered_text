<?php

/**
 * @file
 * Simple REST API implementation of GenderedText.
 *
 * For demo purposes only.
 */

require '../vendor/autoload.php';
require_once '../demo/config.php';

use markfullmer\gendered_text\GenderedText;
use markfullmer\gendered_text\Texts;

if (isset($_REQUEST['get_texts'])) {
  // Retrieve and display a list of available texts.
  $texts = new Texts();
  $contents = $texts->getFolder(DRIVE_FOLDER);
  asort($contents);
  $complete = [];
  foreach ($contents as $key => $title) {
    $text = $texts->getText($key);
    $legend_string = GenderedText::findLegend($text);
    $legend = GenderedText::parseLegend($legend_string);
    $genre = isset($legend['genre']) ? $legend['genre'] : 'Uncategorized';
    $year = isset($legend['year']) ? $legend['year'] : 0;
    $complete[$key]['title'] = $title;
    $complete[$key]['genre'] = $genre;
    $complete[$key]['year'] = $year;
    $cleaned = strip_tags($text);
    $replace = array("\r\n", "\n", "\r", "\t", '.', ',', "'", '@', "{", "}", "(", ")");
    $cleaned = str_replace($replace, ' ', $cleaned);
    $cleaned = str_replace("  ", " ", $cleaned);
    $cleaned = str_replace("  ", " ", $cleaned);
    $cleaned = str_replace("  ", " ", $cleaned);
    $cleaned = str_replace("&", "", $cleaned);
    $cleaned = str_replace(";", "", $cleaned);
    $complete[$key]['wordcount'] = str_word_count($cleaned);
  }
  echo json_encode($complete, JSON_PRETTY_PRINT);
}
elseif (!empty($_REQUEST['text']) && empty($_REQUEST['characters'])) {
  // Allow the user to assign genders.
  $texts = new Texts();
  $text = $texts->getText($_GET['text']);
  if ($text) {
    $legend_string = GenderedText::findLegend($text);
    $legend = GenderedText::parseLegend($legend_string);
    if (!empty($legend)) {
      foreach ($legend as $key => $values) {
        // Exclude "names" array from parsed legend.
        if ($key != 'names' && $key != 'genre' && $key != 'year') {
          $id = implode('/', array_values($values['names']));
          if (!isset($set[$id])) {
            $set[$id]['id'] = $id;
            $set[$id]['gender'] = $values['gender'];
          }
        }
      }
      echo json_encode($set, JSON_PRETTY_PRINT);
    }
  }
}
elseif (!empty($_REQUEST['text']) && !empty($_REQUEST['characters'])) {
  // Display the text!
  $texts = new Texts();
  $text = $texts->getText($_REQUEST['text']);
  if ($text) {
    $legend_string = GenderedText::findLegend($text);
    $text = GenderedText::removeLegend($text, $legend_string);
    $legend = GenderedText::buildLegend($_REQUEST['characters']);
    $result = nl2br(GenderedText::process($text . $legend, WORDMAP_SHEET_ID));
    echo $result;
  }
}
elseif (!empty($_REQUEST['placeholders'])) {
  $result = nl2br(GenderedText::addPlaceholders($_REQUEST['placeholders']));
  echo $result;
}
elseif (!empty($_REQUEST['test'])) {
  $result = nl2br(GenderedText::process($_REQUEST['test'], WORDMAP_SHEET_ID));
  echo $result;
}
