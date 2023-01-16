<?php

/**
 * @file
 * Demonstration file of the PHP Porter 2 English stemming algorithm.
 */

require '../vendor/autoload.php';

include 'header.php';
use markfullmer\gendered_text\GenderedText;

if (empty($_GET['text'])) {
  echo '<h2>Choose a text</h2>';
  $directory = 'texts';
  $texts = array_diff(scandir($directory), array('..', '.'));
  asort($texts);
  echo '<table><thead><th>Author</th><th>Title</th><th>Action</th>';
  foreach ($texts as $filename) {
    $parts = explode('.', $filename);
    echo '<tr><td>' . $parts[0] . '</td><td> ' . $parts[1] . '</td><td><a href="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '?text=' . $filename . '">Assign genders</a></td></tr>';
  }
  echo '</table>';
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
      echo '<form action="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '" method="POST">';
      $genders = ['male', 'female', 'non-binary'];
      foreach ($legend as $key => $values) {
        if ($key != 'names') {
          $list = implode('/', $values['names']);
          if (!in_array($list, $set)) {
            echo '<label style="display:block;" for="characters[' . $list . ']">Gender for "' . $list . '": ';
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
            echo '</label>';
            $set[] = $list;
          }
        }
      }
      echo '<input type="submit" name="submit" value="Read the text" />';
      echo '
        </form>
      </div>';
    }
  }

}
elseif (!empty($_GET['text']) && !empty($_POST['characters'])) {
  // Display the text!
  $file_contents = file('texts/' . $_GET['text']);
  $content = [];
  foreach($file_contents as $line) {
    if (strpos($line, '##') === 0) {
      $line = substr($line, 2);
      $content[] = '<h2>' . $line . '</h2>';
    }
    else {
      $content[] = '<p>' . $line . '</p>';
    }
  }
  $text = implode('', $content);
  if ($text) {
    $legend_string = GenderedText::findLegend($text);
    $text = GenderedText::removeLegend($text, $legend_string);
    $legend = GenderedText::buildLegend($_POST['characters']);
    echo '<a class="button" href="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '">Back to gender selector</a>';
    echo '<p>' . nl2br(GenderedText::process($text . $legend)) . '</p>';
  }
}
?>
</body>
</html>
