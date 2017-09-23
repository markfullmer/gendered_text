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

if (isset($_GET['get_texts'])) {
  // Retrieve and display a list of available texts.
  $texts = new Texts();
  $contents = $texts->getFolder(DRIVE_FOLDER);
  asort($contents);
  echo json_encode($contents, JSON_PRETTY_PRINT);
}
elseif (!empty($_GET['text']) && empty($_GET['characters'])) {
  // Allow the user to assign genders.
  $texts = new Texts();
  $text = $texts->getText($_GET['text']);
  if ($text) {
    $legend_string = GenderedText::findLegend($text);
    $legend = GenderedText::parseLegend($legend_string);
    if (!empty($legend)) {
      foreach ($legend as $key => $values) {
        // Exclude "names" array from parsed legend.
        if ($key != 'names') {
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
elseif (!empty($_GET['text']) && !empty($_GET['characters'])) {
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
